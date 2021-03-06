<?php

/**
 * LimelightProConFlags filter form base class.
 *
 * @package    limelight
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseLimelightProConFlagsFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'limelightprocon_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LimelightProCon'), 'add_empty' => true)),
      'flag_type'          => new sfWidgetFormChoice(array('choices' => array('' => '', 'Duplicate' => 'Duplicate', 'Inappropriate' => 'Inappropriate', 'Spam' => 'Spam', 'Other' => 'Other'))),
      'user_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'created_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'limelightprocon_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('LimelightProCon'), 'column' => 'id')),
      'flag_type'          => new sfValidatorChoice(array('required' => false, 'choices' => array('Duplicate' => 'Duplicate', 'Inappropriate' => 'Inappropriate', 'Spam' => 'Spam', 'Other' => 'Other'))),
      'user_id'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User'), 'column' => 'id')),
      'created_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('limelight_pro_con_flags_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LimelightProConFlags';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'limelightprocon_id' => 'ForeignKey',
      'flag_type'          => 'Enum',
      'user_id'            => 'ForeignKey',
      'created_at'         => 'Date',
      'updated_at'         => 'Date',
    );
  }
}
