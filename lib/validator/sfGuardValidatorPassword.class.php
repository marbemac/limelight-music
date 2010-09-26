<?php

class sfGuardValidatorPassword extends sfValidatorBase
{
  public function configure($options = array(), $messages = array())
  {
    $this->addOption('email_field', 'email');
    $this->addOption('throw_global_error', true);

    $this->setMessage('invalid', 'The email is does not exist in our database! Are you sure this is the email you used when you signed up?');
  }

  protected function doClean($values)
  {
    $email = isset($values[$this->getOption('email_field')]) ? $values[$this->getOption('email_field')] : '';

    // user exists?
    if ($email)
      $user = Doctrine::getTable('sfGuardUser')->retrieveByEmail($email);
    if (isset($user) && $user)
      if ($user->Profile->status != 'Active')
         throw new sfValidatorError($this, 'Your account must be active to reset your password. Your account status is currently set to \''.$user->Profile->status.'\'');
      else
        return array_merge($values, array('user' => $user));
    else
      throw new sfValidatorError($this, $this->getMessage('invalid'));

    throw new sfValidatorErrorSchema($this, array($this->getOption('email_field') => new sfValidatorError($this, 'invalid')));
  }

  protected function getTable()
  {
    return Doctrine::getTable('sfGuardUser');
  }
}