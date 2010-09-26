<?php

/**
 * Source form base class.
 *
 * @method Source getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSourceForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'source_name' => new sfWidgetFormInputText(),
      'status'      => new sfWidgetFormChoice(array('choices' => array('Active' => 'Active', 'Pending' => 'Pending', 'Flagged' => 'Flagged', 'Struck' => 'Struck', 'Disabled' => 'Disabled'))),
      'description' => new sfWidgetFormTextarea(),
      'url'         => new sfWidgetFormInputText(),
      'score'       => new sfWidgetFormInputText(),
      'user_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
      'deleted_at'  => new sfWidgetFormDateTime(),
      'name_slug'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'source_name' => new sfValidatorString(array('max_length' => 255)),
      'status'      => new sfValidatorChoice(array('choices' => array(0 => 'Active', 1 => 'Pending', 2 => 'Flagged', 3 => 'Struck', 4 => 'Disabled'), 'required' => false)),
      'description' => new sfValidatorString(array('max_length' => 400, 'required' => false)),
      'url'         => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'score'       => new sfValidatorInteger(array('required' => false)),
      'user_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'required' => false)),
      'created_at'  => new sfValidatorDateTime(),
      'updated_at'  => new sfValidatorDateTime(),
      'deleted_at'  => new sfValidatorDateTime(array('required' => false)),
      'name_slug'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Source', 'column' => array('name_slug')))
    );

    $this->widgetSchema->setNameFormat('source[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Source';
  }

}
