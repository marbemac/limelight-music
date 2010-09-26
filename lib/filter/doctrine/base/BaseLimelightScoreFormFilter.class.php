<?php

/**
 * LimelightScore filter form base class.
 *
 * @package    limelight
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseLimelightScoreFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'amount'               => new sfWidgetFormFilterInput(),
      'item_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Item'), 'add_empty' => true)),
      'type'                 => new sfWidgetFormChoice(array('choices' => array('' => '', 'News' => 'News', 'Wiki' => 'Wiki', 'LimelightReviewUser' => 'LimelightReviewUser', 'LimelightReviewPro' => 'LimelightReviewPro', 'LimelightProCon' => 'LimelightProCon', 'LimelightSpecification' => 'LimelightSpecification'))),
      'status'               => new sfWidgetFormChoice(array('choices' => array('' => '', 'Flagged' => 'Flagged', 'Struck' => 'Struck', 'Disabled' => 'Disabled', 'Active' => 'Active'))),
      'contributing_item_id' => new sfWidgetFormFilterInput(),
      'user_id'              => new sfWidgetFormFilterInput(),
      'created_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'deleted_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'amount'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'item_id'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Item'), 'column' => 'id')),
      'type'                 => new sfValidatorChoice(array('required' => false, 'choices' => array('News' => 'News', 'Wiki' => 'Wiki', 'LimelightReviewUser' => 'LimelightReviewUser', 'LimelightReviewPro' => 'LimelightReviewPro', 'LimelightProCon' => 'LimelightProCon', 'LimelightSpecification' => 'LimelightSpecification'))),
      'status'               => new sfValidatorChoice(array('required' => false, 'choices' => array('Flagged' => 'Flagged', 'Struck' => 'Struck', 'Disabled' => 'Disabled', 'Active' => 'Active'))),
      'contributing_item_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'user_id'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'deleted_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('limelight_score_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LimelightScore';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'amount'               => 'Number',
      'item_id'              => 'ForeignKey',
      'type'                 => 'Enum',
      'status'               => 'Enum',
      'contributing_item_id' => 'Number',
      'user_id'              => 'Number',
      'created_at'           => 'Date',
      'updated_at'           => 'Date',
      'deleted_at'           => 'Date',
    );
  }
}
