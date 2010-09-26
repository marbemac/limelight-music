<?php

/**
 * FollowingReference form base class.
 *
 * @method FollowingReference getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseFollowingReferenceForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user1' => new sfWidgetFormInputHidden(),
      'user2' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'user1' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('user1')), 'empty_value' => $this->getObject()->get('user1'), 'required' => false)),
      'user2' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('user2')), 'empty_value' => $this->getObject()->get('user2'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('following_reference[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'FollowingReference';
  }

}
