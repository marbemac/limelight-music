<?php

/**
 * LimelightReviewScoreParts form base class.
 *
 * @method LimelightReviewScoreParts getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseLimelightReviewScorePartsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'category_score_type_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CategoryScoreType'), 'add_empty' => true)),
      'review_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LimelightReviewUser'), 'add_empty' => true)),
      'score'                  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'category_score_type_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CategoryScoreType'), 'required' => false)),
      'review_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('LimelightReviewUser'), 'required' => false)),
      'score'                  => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('limelight_review_score_parts[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LimelightReviewScoreParts';
  }

}
