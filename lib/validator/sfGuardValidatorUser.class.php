<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardValidatorUser.class.php 23319 2009-10-25 12:22:23Z Kris.Wallsmith $
 */
class sfGuardValidatorUser extends sfValidatorBase
{
  public function configure($options = array(), $messages = array())
  {
    $this->addOption('username_field', 'username');
    $this->addOption('password_field', 'password');
    $this->addOption('throw_global_error', true);

    $this->addMessage('unconfirmed', 'You have not confirmed this account yet. Please check your inbox for the confirmation email we sent to you.');
    $this->addMessage('wtf', 'WTF do you think you\'re doing... piss off.');
    $this->addMessage('password', 'You are in the process of resetting your password. Please check your email for the reset password notice and finish the process.');
    $this->addMessage('disabled', 'This account has been disabled. If you believe this is an error, please contact us.');
    //$this->addMessage('suspended', '');
    $this->addMessage('system', 'There was an error in the system. Please try again later. If the problem persists please contact us.');
    $this->setMessage('invalid', 'The username/email password combination is invalid.');
  }

  protected function doClean($values)
  {
    $cred = isset($values[$this->getOption('username_field')]) ? $values[$this->getOption('username_field')] : '';
    $password = isset($values[$this->getOption('password_field')]) ? $values[$this->getOption('password_field')] : '';

    // user exists?
    if ($cred)
    {
      $user = Doctrine::getTable('sfGuardUser')->retrieveByUsername($cred);
      if (!$user)
        $user = Doctrine::getTable('sfGuardUser')->retrieveByEmail($cred);
    }
    if (isset($user) && $user) {
      // is the user currently in the process of changing their password?
      if ($user->Profile->status == 'Password')
        throw new sfValidatorError($this, $this->getMessage('password'));

      // password is ok?
      if ($user->checkPassword($password))
      {
        if (sfContext::getInstance()->getConfiguration()->getApplication() == 'backend' && !$user->Profile->is_mod)
          throw new sfValidatorError($this, $this->getMessage('wtf'));

        if ($user->Profile->status == 'Active')
          return array_merge($values, array('user' => $user));
        else if ($user->Profile->status == 'Pending')
          throw new sfValidatorError($this, $this->getMessage('unconfirmed'));
        else if ($user->Profile->status == 'Disabled')
          throw new sfValidatorError($this, $this->getMessage('disabled'));
        else if ($user->Profile->status == 'Suspended') {
          if (date('Y-m-d') >= $user->Profile->suspend_until) {
            $user->Profile->status = 'Active';
            $user->save();
            return array_merge($values, array('user' => $user));
          } else
          throw new sfValidatorError($this, 'This account has been temporarily suspended due to misconduct until '.$user->Profile->suspend_until.'. If you believe this is an error, please contact us.');
        } else
          throw new sfValidatorError($this, $this->getMessage('system'));
      } else
        throw new sfValidatorError($this, $this->getMessage('invalid'));
    } else {
      throw new sfValidatorError($this, $this->getMessage('invalid'));
    }

    throw new sfValidatorErrorSchema($this, array($this->getOption('username_field') => new sfValidatorError($this, 'invalid')));
  }

  protected function getTable()
  {
    return Doctrine::getTable('sfGuardUser');
  }
}
