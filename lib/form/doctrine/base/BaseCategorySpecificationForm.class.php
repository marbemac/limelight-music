<?php

/**
 * CategorySpecification form base class.
 *
 * @method CategorySpecification getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCategorySpecificationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'category_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Category'), 'add_empty' => true)),
      'specification_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Specification'), 'add_empty' => true)),
      'status'           => new sfWidgetFormChoice(array('choices' => array('Active' => 'Active', 'Pending' => 'Pending', 'Struck' => 'Struck', 'Flagged' => 'Flagged', 'Disabled' => 'Disabled'))),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
      'deleted_at'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'category_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Category'), 'required' => false)),
      'specification_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Specification'), 'required' => false)),
      'status'           => new sfValidatorChoice(array('choices' => array(0 => 'Active', 1 => 'Pending', 2 => 'Struck', 3 => 'Flagged', 4 => 'Disabled'), 'required' => false)),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(),
      'deleted_at'       => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('category_specification[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CategorySpecification';
  }

}
