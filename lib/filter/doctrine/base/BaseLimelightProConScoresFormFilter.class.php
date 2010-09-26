<?php

/**
 * LimelightProConScores filter form base class.
 *
 * @package    limelight
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseLimelightProConScoresFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'count'              => new sfWidgetFormFilterInput(),
      'date'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'limelightprocon_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LimelightProCon'), 'add_empty' => true)),
      'user_id'            => new sfWidgetFormFilterInput(),
      'target_user_id'     => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'count'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'date'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'limelightprocon_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('LimelightProCon'), 'column' => 'id')),
      'user_id'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'target_user_id'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('limelight_pro_con_scores_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LimelightProConScores';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'count'              => 'Number',
      'date'               => 'Date',
      'limelightprocon_id' => 'ForeignKey',
      'user_id'            => 'Number',
      'target_user_id'     => 'Number',
    );
  }
}
