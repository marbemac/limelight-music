<?php

/**
 * LimelightScore form base class.
 *
 * @method LimelightScore getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLimelightScoreForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'amount'               => new sfWidgetFormInputText(),
      'item_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Item'), 'add_empty' => true)),
      'type'                 => new sfWidgetFormChoice(array('choices' => array('News' => 'News', 'Wiki' => 'Wiki', 'LimelightReviewUser' => 'LimelightReviewUser', 'LimelightReviewPro' => 'LimelightReviewPro', 'LimelightProCon' => 'LimelightProCon', 'LimelightSpecification' => 'LimelightSpecification'))),
      'status'               => new sfWidgetFormChoice(array('choices' => array('Flagged' => 'Flagged', 'Struck' => 'Struck', 'Disabled' => 'Disabled', 'Active' => 'Active'))),
      'contributing_item_id' => new sfWidgetFormInputText(),
      'user_id'              => new sfWidgetFormInputText(),
      'created_at'           => new sfWidgetFormDateTime(),
      'updated_at'           => new sfWidgetFormDateTime(),
      'deleted_at'           => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'amount'               => new sfValidatorInteger(array('required' => false)),
      'item_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Item'), 'required' => false)),
      'type'                 => new sfValidatorChoice(array('choices' => array(0 => 'News', 1 => 'Wiki', 2 => 'LimelightReviewUser', 3 => 'LimelightReviewPro', 4 => 'LimelightProCon', 5 => 'LimelightSpecification'), 'required' => false)),
      'status'               => new sfValidatorChoice(array('choices' => array(0 => 'Flagged', 1 => 'Struck', 2 => 'Disabled', 3 => 'Active'), 'required' => false)),
      'contributing_item_id' => new sfValidatorInteger(array('required' => false)),
      'user_id'              => new sfValidatorInteger(array('required' => false)),
      'created_at'           => new sfValidatorDateTime(),
      'updated_at'           => new sfValidatorDateTime(),
      'deleted_at'           => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('limelight_score[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LimelightScore';
  }

}
