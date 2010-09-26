<?php

/**
 * LimelightReviewScorePart form base class.
 *
 * @method LimelightReviewScorePart getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLimelightReviewScorePartForm extends BaseFormDoctrine
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
      'id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'category_score_type_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CategoryScoreType'), 'required' => false)),
      'review_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('LimelightReviewUser'), 'required' => false)),
      'score'                  => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('limelight_review_score_part[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LimelightReviewScorePart';
  }

}
