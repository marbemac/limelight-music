<?php

/**
 * LimelightReviewScorePart filter form base class.
 *
 * @package    limelight
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseLimelightReviewScorePartFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'category_score_type_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CategoryScoreType'), 'add_empty' => true)),
      'review_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LimelightReviewUser'), 'add_empty' => true)),
      'score'                  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'category_score_type_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('CategoryScoreType'), 'column' => 'id')),
      'review_id'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('LimelightReviewUser'), 'column' => 'id')),
      'score'                  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('limelight_review_score_part_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LimelightReviewScorePart';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'category_score_type_id' => 'ForeignKey',
      'review_id'              => 'ForeignKey',
      'score'                  => 'Number',
    );
  }
}
