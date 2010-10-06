<?php

/**
 * Profile form base class.
 *
 * @method Profile getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProfileForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'sf_guard_user_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'first_name'           => new sfWidgetFormInputText(),
      'last_name'            => new sfWidgetFormInputText(),
      'zipcode'              => new sfWidgetFormInputText(),
      'gender'               => new sfWidgetFormInputText(),
      'age_range'            => new sfWidgetFormInputText(),
      'rpx_birthday'         => new sfWidgetFormDate(),
      'rpx_url'              => new sfWidgetFormInputText(),
      'income_range'         => new sfWidgetFormInputText(),
      'email'                => new sfWidgetFormInputText(),
      'total_views'          => new sfWidgetFormInputText(),
      'status'               => new sfWidgetFormChoice(array('choices' => array('Active' => 'Active', 'Pending' => 'Pending', 'Flagged' => 'Flagged', 'Struck' => 'Struck', 'Disabled' => 'Disabled'))),
      'activate_code'        => new sfWidgetFormInputText(),
      'activated'            => new sfWidgetFormInputText(),
      'profile_image'        => new sfWidgetFormTextarea(),
      'rpx_profile_image'    => new sfWidgetFormInputText(),
      'score'                => new sfWidgetFormInputText(),
      'score_ratio'          => new sfWidgetFormInputText(),
      'score_positive_count' => new sfWidgetFormInputText(),
      'score_negative_count' => new sfWidgetFormInputText(),
      'limelight_count'      => new sfWidgetFormInputText(),
      'flag_count'           => new sfWidgetFormInputText(),
      'login_count'          => new sfWidgetFormInputText(),
      'song_playing_id'      => new sfWidgetFormInputText(),
      'first_100'            => new sfWidgetFormInputText(),
      'first_1000'           => new sfWidgetFormInputText(),
      'is_mod'               => new sfWidgetFormInputText(),
      'suspend_until'        => new sfWidgetFormDate(),
      'created_at'           => new sfWidgetFormDateTime(),
      'updated_at'           => new sfWidgetFormDateTime(),
      'deleted_at'           => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'sf_guard_user_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'required' => false)),
      'first_name'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'last_name'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'zipcode'              => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'gender'               => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'age_range'            => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'rpx_birthday'         => new sfValidatorDate(array('required' => false)),
      'rpx_url'              => new sfValidatorPass(array('required' => false)),
      'income_range'         => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'email'                => new sfValidatorEmail(array('max_length' => 255)),
      'total_views'          => new sfValidatorInteger(array('required' => false)),
      'status'               => new sfValidatorChoice(array('choices' => array(0 => 'Active', 1 => 'Pending', 2 => 'Flagged', 3 => 'Struck', 4 => 'Disabled'), 'required' => false)),
      'activate_code'        => new sfValidatorString(array('max_length' => 14)),
      'activated'            => new sfValidatorInteger(array('required' => false)),
      'profile_image'        => new sfValidatorString(array('required' => false)),
      'rpx_profile_image'    => new sfValidatorPass(array('required' => false)),
      'score'                => new sfValidatorInteger(array('required' => false)),
      'score_ratio'          => new sfValidatorNumber(array('required' => false)),
      'score_positive_count' => new sfValidatorInteger(array('required' => false)),
      'score_negative_count' => new sfValidatorInteger(array('required' => false)),
      'limelight_count'      => new sfValidatorInteger(array('required' => false)),
      'flag_count'           => new sfValidatorInteger(array('required' => false)),
      'login_count'          => new sfValidatorInteger(array('required' => false)),
      'song_playing_id'      => new sfValidatorInteger(array('required' => false)),
      'first_100'            => new sfValidatorPass(array('required' => false)),
      'first_1000'           => new sfValidatorPass(array('required' => false)),
      'is_mod'               => new sfValidatorPass(array('required' => false)),
      'suspend_until'        => new sfValidatorDate(array('required' => false)),
      'created_at'           => new sfValidatorDateTime(),
      'updated_at'           => new sfValidatorDateTime(),
      'deleted_at'           => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('profile[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Profile';
  }

}
