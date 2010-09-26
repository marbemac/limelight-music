<?php

/**
 * UserAction filter form base class.
 *
 * @package    limelight
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseUserActionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'Limelight_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Limelights'), 'add_empty' => true)),
      'News_id'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('News'), 'add_empty' => true)),
      'Comment_id'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Comments'), 'add_empty' => true)),
      'LimelightProCon_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LimelightProcons'), 'add_empty' => true)),
      'Wiki_id'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Wikis'), 'add_empty' => true)),
      'LimelightReviewUser_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LimelightUserReviews'), 'add_empty' => true)),
      'LimelightReviewPro_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LimelightProReviews'), 'add_empty' => true)),
      'LimelightSpecification_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LimelightSpecifications'), 'add_empty' => true)),
      'NewsTag_id'                => new sfWidgetFormFilterInput(),
      'type'                      => new sfWidgetFormFilterInput(),
      'user_id'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'status'                    => new sfWidgetFormChoice(array('choices' => array('' => '', 'Active' => 'Active', 'Pending' => 'Pending', 'Flagged' => 'Flagged', 'Struck' => 'Struck', 'Disabled' => 'Disabled'))),
      'created_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'deleted_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'Limelight_id'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Limelights'), 'column' => 'id')),
      'News_id'                   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('News'), 'column' => 'id')),
      'Comment_id'                => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Comments'), 'column' => 'id')),
      'LimelightProCon_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('LimelightProcons'), 'column' => 'id')),
      'Wiki_id'                   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Wikis'), 'column' => 'id')),
      'LimelightReviewUser_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('LimelightUserReviews'), 'column' => 'id')),
      'LimelightReviewPro_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('LimelightProReviews'), 'column' => 'id')),
      'LimelightSpecification_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('LimelightSpecifications'), 'column' => 'id')),
      'NewsTag_id'                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'type'                      => new sfValidatorPass(array('required' => false)),
      'user_id'                   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User'), 'column' => 'id')),
      'status'                    => new sfValidatorChoice(array('required' => false, 'choices' => array('Active' => 'Active', 'Pending' => 'Pending', 'Flagged' => 'Flagged', 'Struck' => 'Struck', 'Disabled' => 'Disabled'))),
      'created_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'deleted_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('user_action_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserAction';
  }

  public function getFields()
  {
    return array(
      'id'                        => 'Number',
      'Limelight_id'              => 'ForeignKey',
      'News_id'                   => 'ForeignKey',
      'Comment_id'                => 'ForeignKey',
      'LimelightProCon_id'        => 'ForeignKey',
      'Wiki_id'                   => 'ForeignKey',
      'LimelightReviewUser_id'    => 'ForeignKey',
      'LimelightReviewPro_id'     => 'ForeignKey',
      'LimelightSpecification_id' => 'ForeignKey',
      'NewsTag_id'                => 'Number',
      'type'                      => 'Text',
      'user_id'                   => 'ForeignKey',
      'status'                    => 'Enum',
      'created_at'                => 'Date',
      'updated_at'                => 'Date',
      'deleted_at'                => 'Date',
    );
  }
}
