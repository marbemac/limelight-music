<?php

/**
 * LimelightSpec form base class.
 *
 * @method LimelightSpec getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLimelightSpecForm extends ItemForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['name'] = new sfWidgetFormInputText();
    $this->validatorSchema['name'] = new sfValidatorString(array('max_length' => 50, 'required' => false));

    $this->widgetSchema   ['name_slug'] = new sfWidgetFormInputText();
    $this->validatorSchema['name_slug'] = new sfValidatorString(array('max_length' => 255, 'required' => false));

    $this->widgetSchema   ['content'] = new sfWidgetFormInputText();
    $this->validatorSchema['content'] = new sfValidatorString(array('max_length' => 150, 'required' => false));

    $this->widgetSchema   ['source_name'] = new sfWidgetFormInputText();
    $this->validatorSchema['source_name'] = new sfValidatorString(array('max_length' => 50, 'required' => false));

    $this->widgetSchema   ['source_url'] = new sfWidgetFormInputText();
    $this->validatorSchema['source_url'] = new sfValidatorString(array('max_length' => 255, 'required' => false));

    $this->widgetSchema   ['limelight_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Limelight'), 'add_empty' => true));
    $this->validatorSchema['limelight_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Limelight'), 'required' => false));

    $this->widgetSchema->setNameFormat('limelight_spec[%s]');
  }

  public function getModelName()
  {
    return 'LimelightSpec';
  }

}
