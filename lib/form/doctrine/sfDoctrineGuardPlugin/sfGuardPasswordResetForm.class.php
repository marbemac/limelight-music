<?php

/**
 * BasesfGuardFormSignin
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage form
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: BasesfGuardFormSignin.class.php 23536 2009-11-02 21:41:21Z Kris.Wallsmith $
 */
class sfGuardPasswordResetForm extends BaseForm
{
  /**
   * @see sfForm
   */
  public function setup()
  {
    $this->setWidgets(array(
      'code' => new sfWidgetFormInputText(),
      'password' => new sfWidgetFormInputPassword(array(), array('class' => 'rnd_5')),
      'password2' => new sfWidgetFormInputPassword(array(), array('class' => 'rnd_5')),
      'username' => new sfWidgetFormInputText(array(), array()),
    ));

    $this->widgetSchema->setLabels(array(
      'code'      => 'Validation Code',
      'password'  => 'New Password',
      'password2' => 'Repeat Password',
    ));

    $this->setValidators(array(
      'code' => new sfValidatorString(array('trim' => true, 'required' => true)),
      'password' => new sfValidatorString(array('trim' => true, 'required' => true, 'min_length' => 6, 'max_length' => 20)),
      'password2' => new sfValidatorString(array('trim' => true, 'required' => true, 'min_length' => 6, 'max_length' => 20)),
      'username' => new sfValidatorString(array('trim' => true, 'required' => true)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(
        array(
          new sfValidatorSchemaCompare('password', '==', 'password2', array(), array('invalid' => 'The passwords you entered do not match')),
          new sfGuardValidatorPasswordReset()
        )
      )
    );

    $this->validatorSchema->setOption('allow_extra_fields', true);

    $this->widgetSchema->setNameFormat('passwordReset[%s]');
  }
}