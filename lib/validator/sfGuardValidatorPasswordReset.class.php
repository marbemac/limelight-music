<?php

class sfGuardValidatorPasswordReset extends sfValidatorBase
{
  public function configure($options = array(), $messages = array())
  {
    $this->addOption('code_field', 'code');
    $this->addOption('username_field', 'username');
    $this->addOption('throw_global_error', true);

    $this->addMessage('status', 'This account is not allowed to change it\'s password right now. Please click on the \'login\' link and then click the \'change password\' link to begin the process.' );
    $this->addMessage('invalid_code', 'There was an error with the validation code. Are you sure you copied it correctly? If you believe this is an error please contact us via the website contact page.');
    $this->setMessage('invalid', 'No user with the specified username exists in our database. Are you sure you copied the link correctly?');
  }

  protected function doClean($values)
  {
    $username = isset($values[$this->getOption('username_field')]) ? $values[$this->getOption('username_field')] : '';
    $code = isset($values[$this->getOption('code_field')]) ? $values[$this->getOption('code_field')] : '';
    
    // user exists?
    if ($username)
      $user = Doctrine::getTable('sfGuardUser')->retrieveByUsername($username);
    if (isset($user) && $user)
    {
      if ($user->checkPassword($code))
        return array_merge($values, array('user' => $user));
      else
        throw new sfValidatorError($this, $this->getMessage('invalid_code'));
    }
    else
      throw new sfValidatorError($this, $this->getMessage('invalid'));

    throw new sfValidatorErrorSchema($this, array($this->getOption('username_field') => new sfValidatorError($this, 'invalid')));
  }

  protected function getTable()
  {
    return Doctrine::getTable('sfGuardUser');
  }
}