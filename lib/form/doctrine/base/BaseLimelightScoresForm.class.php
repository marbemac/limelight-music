<?php

/**
 * LimelightScores form base class.
 *
 * @method LimelightScores getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseLimelightScoresForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'count'          => new sfWidgetFormInputText(),
      'limelight_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Limelight'), 'add_empty' => true)),
      'user_id'        => new sfWidgetFormInputText(),
      'target_user_id' => new sfWidgetFormInputText(),
      'score_type'     => new sfWidgetFormChoice(array('choices' => array('News' => 'News'))),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'count'          => new sfValidatorInteger(array('required' => false)),
      'limelight_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Limelight'), 'required' => false)),
      'user_id'        => new sfValidatorInteger(array('required' => false)),
      'target_user_id' => new sfValidatorInteger(array('required' => false)),
      'score_type'     => new sfValidatorChoice(array('choices' => array(0 => 'News'), 'required' => false)),
      'created_at'     => new sfValidatorDateTime(),
      'updated_at'     => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('limelight_scores[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LimelightScores';
  }

}
