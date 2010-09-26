<?php

sfProjectConfiguration::getActive()->loadHelpers('Url');

class RegisterForm extends PluginsfGuardUserForm
{
  public function configure()
  {
    unset(
      $this['is_active'],
      $this['is_super_admin'],
      $this['updated_at'],
      $this['groups_list'],
      $this['permissions_list'],
      $this['last_login'],
      $this['created_at'],
      $this['salt'],
      $this['algorithm']
    );

    $this->setWidgets(array(
      'username'   => new sfWidgetFormInputText(array(),
        array(
          'class'     => 'reg_field rnd_5',
          'maxlength' => 15,
          'data-url'  => url_for('user/checkUsername')
        )),
      'password'   => new sfWidgetFormInputPassword(array(), array('class' => 'rnd_5')),
      'password2'  => new sfWidgetFormInputPassword(array(), array('class' => 'rnd_5')),
    ));

    $this->widgetSchema->setLabels(array(
      'email2' => 'Repeat Email',
      'password2' => 'Repeat Password',
    ));

    $this->setValidators(array(
      'username'   => new sfValidatorString(array('trim' => true, 'required' => true, 'min_length' => 3, 'max_length' => 12)),
      'password'   => new sfValidatorString(array('trim' => true, 'required' => true, 'min_length' => 6, 'max_length' => 20)),
      'password2'  => new sfValidatorString(array('trim' => true, 'required' => true, 'min_length' => 6, 'max_length' => 20)),
    ));

    // Check the passwords and emails are the same, and that the username and email are unique
    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(
        array(
          new sfValidatorSchemaCompare('password', '==', 'password2',
            array(),
            array('invalid' => 'The passwords you entered do not match')),
          new sfValidatorDoctrineUnique(array('model' => 'sfGuardUser', 'column' => 'username'))
        )
      )
    );

    $profile = new ProfileForm();
    $this->mergeForm($profile);

    if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1') {
      $this->setWidget('captcha', new sfWidgetFormReCaptcha(array('public_key' => sfConfig::get('app_recaptcha_public_key'))));
      $this->setValidator('captcha', new sfValidatorReCaptcha(array(
        'private_key' => sfConfig::get('app_recaptcha_private_key'),
        'remote_addr' => substr($_SERVER['REMOTE_ADDR'], 8)
      )));
      $this->widgetSchema->setLabel('captcha', 'Human or robot? We\'ll see...');
    }

    $this->validatorSchema->setOption('allow_extra_fields', true);

    $this->widgetSchema->setNameFormat('user[%s]');
  }
}