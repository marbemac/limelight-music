<?php

/**
 * UserScore filter form base class.
 *
 * @package    limelight
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseUserScoreFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'amount'         => new sfWidgetFormFilterInput(),
      'type'           => new sfWidgetFormChoice(array('choices' => array('' => '', 'News' => 'News', 'Comment' => 'Comment', 'NewsTag' => 'NewsTag', 'LimelightProCon' => 'LimelightProCon', 'LimelightReviewPro' => 'LimelightReviewPro', 'LimelightReviewUser' => 'LimelightReviewUser', 'LimelightSpecification' => 'LimelightSpecification', 'LimelightWiki' => 'LimelightWiki'))),
      'status'         => new sfWidgetFormChoice(array('choices' => array('' => '', 'Flagged' => 'Flagged', 'Struck' => 'Struck', 'Disabled' => 'Disabled', 'Active' => 'Active'))),
      'item_id'        => new sfWidgetFormFilterInput(),
      'user_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Rater'), 'add_empty' => true)),
      'target_user_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TargetUser'), 'add_empty' => true)),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'deleted_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'amount'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'type'           => new sfValidatorChoice(array('required' => false, 'choices' => array('News' => 'News', 'Comment' => 'Comment', 'NewsTag' => 'NewsTag', 'LimelightProCon' => 'LimelightProCon', 'LimelightReviewPro' => 'LimelightReviewPro', 'LimelightReviewUser' => 'LimelightReviewUser', 'LimelightSpecification' => 'LimelightSpecification', 'LimelightWiki' => 'LimelightWiki'))),
      'status'         => new sfValidatorChoice(array('required' => false, 'choices' => array('Flagged' => 'Flagged', 'Struck' => 'Struck', 'Disabled' => 'Disabled', 'Active' => 'Active'))),
      'item_id'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'user_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Rater'), 'column' => 'id')),
      'target_user_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TargetUser'), 'column' => 'id')),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'deleted_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('user_score_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserScore';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'amount'         => 'Number',
      'type'           => 'Enum',
      'status'         => 'Enum',
      'item_id'        => 'Number',
      'user_id'        => 'ForeignKey',
      'target_user_id' => 'ForeignKey',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
      'deleted_at'     => 'Date',
    );
  }
}
