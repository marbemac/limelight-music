<?php

/**
 * LimelightProConScores form base class.
 *
 * @method LimelightProConScores getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseLimelightProConScoresForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'count'              => new sfWidgetFormInputText(),
      'date'               => new sfWidgetFormDate(),
      'limelightprocon_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LimelightProCon'), 'add_empty' => true)),
      'user_id'            => new sfWidgetFormInputText(),
      'target_user_id'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'count'              => new sfValidatorInteger(array('required' => false)),
      'date'               => new sfValidatorDate(array('required' => false)),
      'limelightprocon_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('LimelightProCon'), 'required' => false)),
      'user_id'            => new sfValidatorInteger(array('required' => false)),
      'target_user_id'     => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('limelight_pro_con_scores[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LimelightProConScores';
  }

}
