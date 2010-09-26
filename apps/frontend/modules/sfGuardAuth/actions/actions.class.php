<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(sfConfig::get('sf_plugins_dir').'/sfDoctrineGuardPlugin/modules/sfGuardAuth/lib/BasesfGuardAuthActions.class.php');

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: actions.class.php 7634 2008-02-27 18:01:40Z fabien $
 */
class sfGuardAuthActions extends BasesfGuardAuthActions
{

  public function executeSignout($request)
  {
    $this->getUser()->signOut();

    $signout_url = sfConfig::get('app_sf_guard_plugin_success_signout_url', $request->getReferer());
    $this->getUser()->setFlash('notice', 'You have been successfully logged out.');
    $this->redirect('' != $signout_url ? $signout_url : '@homepage');
  }
  
  public function executeSignin($request)
  {
    $user = $this->getUser();
    if ($user->isAuthenticated())
    {
      return $this->redirect('@homepage');
    }

    $class = sfConfig::get('app_sf_guard_plugin_signin_form', 'sfGuardFormSignin');
    $this->form = new $class();

    if ($request->isMethod('POST'))
    {
      $this->form->bind($request->getParameter('signin'));
      if ($this->form->isValid())
      {
        $values = $this->form->getValues();

        $user = Doctrine::getTable('sfGuardUser')->findOneByUsername($values['username']);
        if (!$user)
          $user = Doctrine::getTable('sfGuardUser')->retrieveByEmail($values['username']);

        # update the Loyalty badge if this is the first consecutive login of the day since yesterday
        $td = 0;
        if ($user->last_login == null)
        {
          Doctrine::getTable('Badge')->increaseBadgeStat('Loyalty', $user->id);
        }
        else {
          $last_login = strtotime($user->last_login);
          $td = mktime(0, 0, 0, date('n'), date('j'), date('Y')) - mktime(0, 0, 0, date('n', $last_login), date('j', $last_login), date('Y', $last_login));
          $td = $td/24/60/60;
        }
        if ($td == 1)
          Doctrine::getTable('Badge')->increaseBadgeStat('Loyalty', $user->id);
        else if ($td > 1)
          Doctrine::getTable('Badge')->setBadgeStat('Loyalty', $user->id, 1);

        $this->getUser()->signin($values['user'], array_key_exists('remember', $values) ? $values['remember'] : false);
        
        $user->Profile->login_count += 1;
        $user->checkBadges();
        $user->adjustModLevels();
        $user->save();

        $this->renderText('logged');
        return sfView::NONE;
      }
    }
  }
  
  public function executePassword($request)
  {
    $user = $this->getUser();
    if ($user->isAuthenticated())
    {
      return $this->redirect('@homepage');
    }

    $this->form = new sfGuardPasswordForm();

    if ($request->isMethod('POST'))
    {
      $this->form->bind($request->getParameter('password'));
      if ($this->form->isValid())
      {
        $values = $this->form->getValues();

        $user = Doctrine::getTable('sfGuardUser')->retrieveByEmail($values['email']);
        $code = uniqid('UP');
        $user->password = $code;
        $user->Profile->status = 'Password';
        $user->save();

        $message = Swift_Message::newInstance()
          ->setFrom('no-reply@techlimelight.com')
          ->setTo($user->Profile->email)
          ->setSubject(sfConfig::get('app_site_name').' password reset notice. Please read, action required!')
          ->setBody($this->getPartial('passwordEmail', array('username' => $user->username, 'code' => $code)), 'text/html')
        ;
        $this->getMailer()->send($message);

        $this->getUser()->setFlash('notice', 'A password reset email has been sent to your email address. Please check your email shortly and follow the instructions to reset your password.');
        $this->getResponse()->setHttpHeader('Content-Type', 'json', TRUE);
        $this->renderText('{ "text":"changed" }');
        return sfView::NONE;
      }
    }
  }

  public function executePasswordReset($request)
  {
    $user = $this->getUser();
    if ($user->isAuthenticated())
    {
      return $this->redirect('@homepage');
    }

    $this->form = new sfGuardPasswordResetForm();

    if ($request->isMethod('POST'))
    {
      $this->form->bind($request->getParameter('passwordReset'));
      if ($this->form->isValid())
      {
        $this->getUser()->setFlash('notice', 'valid');
        $values = $this->form->getValues();

        $user = Doctrine::getTable('sfGuardUser')->retrieveByUsername($values['username']);
        $user->password = $values['password'];
        $user->Profile->status = 'Active';
        $user->save();

        $message = Swift_Message::newInstance()
          ->setFrom('no-reply@techlimelight.com')
          ->setTo($user->Profile->email)
          ->setSubject(sfConfig::get('app_site_name').' password successfully reset!')
          ->setBody($this->getPartial('passwordResetEmail', array('username' => $user->username)), 'text/html')
        ;
        $this->getMailer()->send($message);

        $this->getUser()->setFlash('notice', 'Your password has been successfully changed. You may now login. An email confirmation has been sent to your email address.');
        return $this->redirect('@homepage');
      }
    }
  }
}
