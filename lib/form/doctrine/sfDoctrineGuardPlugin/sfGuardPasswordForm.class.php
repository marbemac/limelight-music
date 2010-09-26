<?php

/**
 * BasesfGuardFormSignin
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage form
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: BasesfGuardFormSignin.class.php 23536 2009-11-02 21:41:21Z Kris.Wallsmith $
 */
class sfGuardPasswordForm extends BaseForm
{
  /**
   * @see sfForm
   */
  public function setup()
  {
    $this->setWidgets(array(
      'email' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'email' => new sfValidatorEmail(array('trim' => true, 'required' => true)),
    ));

    $this->validatorSchema->setPostValidator(new sfGuardValidatorPassword());

    $this->widgetSchema->setNameFormat('password[%s]');
  }
}