<?php

/**
 * Score form base class.
 *
 * @method Score getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseScoreForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'amount'         => new sfWidgetFormInputText(),
      'status'         => new sfWidgetFormChoice(array('choices' => array('Flagged' => 'Flagged', 'Struck' => 'Struck', 'Disabled' => 'Disabled', 'Active' => 'Active'))),
      'user_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Rater'), 'add_empty' => true)),
      'target_user_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TargetUser'), 'add_empty' => true)),
      'item_id'        => new sfWidgetFormInputText(),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
      'deleted_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'amount'         => new sfValidatorInteger(array('required' => false)),
      'status'         => new sfValidatorChoice(array('choices' => array(0 => 'Flagged', 1 => 'Struck', 2 => 'Disabled', 3 => 'Active'), 'required' => false)),
      'user_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Rater'), 'required' => false)),
      'target_user_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TargetUser'), 'required' => false)),
      'item_id'        => new sfValidatorInteger(array('required' => false)),
      'created_at'     => new sfValidatorDateTime(),
      'updated_at'     => new sfValidatorDateTime(),
      'deleted_at'     => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('score[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Score';
  }

}
