<?php

/**
 * LimelightSlice form base class.
 *
 * @method LimelightSlice getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLimelightSliceForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'name'          => new sfWidgetFormInputText(),
      'profile_image' => new sfWidgetFormInputText(),
      'slice_type'    => new sfWidgetFormChoice(array('choices' => array('model' => 'model', 'version' => 'version', 'album' => 'album'))),
      'user_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'item_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Limelight'), 'add_empty' => true)),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
      'deleted_at'    => new sfWidgetFormDateTime(),
      'name_slug'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'          => new sfValidatorString(array('max_length' => 255)),
      'profile_image' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'slice_type'    => new sfValidatorChoice(array('choices' => array(0 => 'model', 1 => 'version', 2 => 'album'), 'required' => false)),
      'user_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'required' => false)),
      'item_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Limelight'), 'required' => false)),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
      'deleted_at'    => new sfValidatorDateTime(array('required' => false)),
      'name_slug'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'LimelightSlice', 'column' => array('name_slug')))
    );

    $this->widgetSchema->setNameFormat('limelight_slice[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LimelightSlice';
  }

}
