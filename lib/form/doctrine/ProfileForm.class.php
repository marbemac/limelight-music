<?php

sfProjectConfiguration::getActive()->loadHelpers('Url');

/**
 * Profile form.
 *
 * @package    form
 * @subpackage Profile
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class ProfileForm extends BaseProfileForm
{
  public function configure()
  {

    unset(
      $this['sf_guard_user_id'],
      $this['name'],
      $this['status'],
      $this['activate_code'],
      $this['activated']
    );

    $this->setWidgets(array(
      'email'      => new sfWidgetFormInputText(array(),
        array(
          'class' => 'reg_field rnd_5',
          'maxlength' => 100,
          'onblur' => "jQuery.ajax({type:'POST',dataType:'html',
                          data:'email='+this.value,
                          success:function(data, textStatus){jQuery('#email_error').show().html(data);},
                          url:'".url_for('user/checkEmail')."'})"
        )),
      'email2'     => new sfWidgetFormInputText(array(), array('class' => 'reg_field rnd_5'))
    ));

    $this->widgetSchema->setLabels(array(
      'email' => 'Email',
      'email2' => 'Repeat Email'
    ));

    $this->setValidators(array(
      'email'      => new sfValidatorEmail(array('trim' => true, 'required' => true), array('invalid' => 'The email address is invalid.')),
      'email2'     => new sfValidatorEmail(array('trim' => true, 'required' => true), array('invalid' => 'The email address is invalid.'))
    ));

    /*
     *  Check emails are the same, email is unique
     */
    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(
        array(
          new sfValidatorSchemaCompare('email', '==', 'email2',
            array(),
            array('invalid' => 'The emails you entered do not match')),
          new sfValidatorDoctrineUnique(array('model' => 'Profile', 'column' => 'email'))
        )
      )
    );

    $this->widgetSchema->setNameFormat('user[%s]');
  }
}