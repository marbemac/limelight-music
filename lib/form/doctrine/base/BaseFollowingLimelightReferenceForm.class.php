<?php

/**
 * FollowingLimelightReference form base class.
 *
 * @method FollowingLimelightReference getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseFollowingLimelightReferenceForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'      => new sfWidgetFormInputHidden(),
      'limelight_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'user_id'      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('user_id')), 'empty_value' => $this->getObject()->get('user_id'), 'required' => false)),
      'limelight_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('limelight_id')), 'empty_value' => $this->getObject()->get('limelight_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('following_limelight_reference[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'FollowingLimelightReference';
  }

}
