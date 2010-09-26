<?php

/**
 * CategoryLimelight form base class.
 *
 * @method CategoryLimelight getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCategoryLimelightForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'limelight_id' => new sfWidgetFormInputHidden(),
      'category_id'  => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'limelight_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('limelight_id')), 'empty_value' => $this->getObject()->get('limelight_id'), 'required' => false)),
      'category_id'  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('category_id')), 'empty_value' => $this->getObject()->get('category_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('category_limelight[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CategoryLimelight';
  }

}
