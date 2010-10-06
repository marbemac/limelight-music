<?php

/**
 * Profile filter form base class.
 *
 * @package    limelight
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseProfileFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'sf_guard_user_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'first_name'           => new sfWidgetFormFilterInput(),
      'last_name'            => new sfWidgetFormFilterInput(),
      'zipcode'              => new sfWidgetFormFilterInput(),
      'gender'               => new sfWidgetFormFilterInput(),
      'age_range'            => new sfWidgetFormFilterInput(),
      'rpx_birthday'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'rpx_url'              => new sfWidgetFormFilterInput(),
      'income_range'         => new sfWidgetFormFilterInput(),
      'email'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'total_views'          => new sfWidgetFormFilterInput(),
      'status'               => new sfWidgetFormChoice(array('choices' => array('' => '', 'Active' => 'Active', 'Pending' => 'Pending', 'Flagged' => 'Flagged', 'Struck' => 'Struck', 'Disabled' => 'Disabled'))),
      'activate_code'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'activated'            => new sfWidgetFormFilterInput(),
      'profile_image'        => new sfWidgetFormFilterInput(),
      'rpx_profile_image'    => new sfWidgetFormFilterInput(),
      'score'                => new sfWidgetFormFilterInput(),
      'score_ratio'          => new sfWidgetFormFilterInput(),
      'score_positive_count' => new sfWidgetFormFilterInput(),
      'score_negative_count' => new sfWidgetFormFilterInput(),
      'limelight_count'      => new sfWidgetFormFilterInput(),
      'flag_count'           => new sfWidgetFormFilterInput(),
      'login_count'          => new sfWidgetFormFilterInput(),
      'song_playing_id'      => new sfWidgetFormFilterInput(),
      'first_100'            => new sfWidgetFormFilterInput(),
      'first_1000'           => new sfWidgetFormFilterInput(),
      'is_mod'               => new sfWidgetFormFilterInput(),
      'suspend_until'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'deleted_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'sf_guard_user_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User'), 'column' => 'id')),
      'first_name'           => new sfValidatorPass(array('required' => false)),
      'last_name'            => new sfValidatorPass(array('required' => false)),
      'zipcode'              => new sfValidatorPass(array('required' => false)),
      'gender'               => new sfValidatorPass(array('required' => false)),
      'age_range'            => new sfValidatorPass(array('required' => false)),
      'rpx_birthday'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'rpx_url'              => new sfValidatorPass(array('required' => false)),
      'income_range'         => new sfValidatorPass(array('required' => false)),
      'email'                => new sfValidatorPass(array('required' => false)),
      'total_views'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'status'               => new sfValidatorChoice(array('required' => false, 'choices' => array('Active' => 'Active', 'Pending' => 'Pending', 'Flagged' => 'Flagged', 'Struck' => 'Struck', 'Disabled' => 'Disabled'))),
      'activate_code'        => new sfValidatorPass(array('required' => false)),
      'activated'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'profile_image'        => new sfValidatorPass(array('required' => false)),
      'rpx_profile_image'    => new sfValidatorPass(array('required' => false)),
      'score'                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'score_ratio'          => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'score_positive_count' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'score_negative_count' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'limelight_count'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'flag_count'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'login_count'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'song_playing_id'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'first_100'            => new sfValidatorPass(array('required' => false)),
      'first_1000'           => new sfValidatorPass(array('required' => false)),
      'is_mod'               => new sfValidatorPass(array('required' => false)),
      'suspend_until'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'created_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'deleted_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('profile_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Profile';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'sf_guard_user_id'     => 'ForeignKey',
      'first_name'           => 'Text',
      'last_name'            => 'Text',
      'zipcode'              => 'Text',
      'gender'               => 'Text',
      'age_range'            => 'Text',
      'rpx_birthday'         => 'Date',
      'rpx_url'              => 'Text',
      'income_range'         => 'Text',
      'email'                => 'Text',
      'total_views'          => 'Number',
      'status'               => 'Enum',
      'activate_code'        => 'Text',
      'activated'            => 'Number',
      'profile_image'        => 'Text',
      'rpx_profile_image'    => 'Text',
      'score'                => 'Number',
      'score_ratio'          => 'Number',
      'score_positive_count' => 'Number',
      'score_negative_count' => 'Number',
      'limelight_count'      => 'Number',
      'flag_count'           => 'Number',
      'login_count'          => 'Number',
      'song_playing_id'      => 'Number',
      'first_100'            => 'Text',
      'first_1000'           => 'Text',
      'is_mod'               => 'Text',
      'suspend_until'        => 'Date',
      'created_at'           => 'Date',
      'updated_at'           => 'Date',
      'deleted_at'           => 'Date',
    );
  }
}
