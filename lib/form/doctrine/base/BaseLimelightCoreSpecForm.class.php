<?php

/**
 * LimelightCoreSpec form base class.
 *
 * @method LimelightCoreSpec getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLimelightCoreSpecForm extends ItemForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['name'] = new sfWidgetFormChoice(array('choices' => array('Manufacturer' => 'Manufacturer', 'Release Date' => 'Release Date', 'MSRP' => 'MSRP')));
    $this->validatorSchema['name'] = new sfValidatorChoice(array('choices' => array(0 => 'Manufacturer', 1 => 'Release Date', 2 => 'MSRP'), 'required' => false));

    $this->widgetSchema   ['content'] = new sfWidgetFormInputText();
    $this->validatorSchema['content'] = new sfValidatorString(array('max_length' => 150, 'required' => false));

    $this->widgetSchema   ['limelight_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Limelight'), 'add_empty' => true));
    $this->validatorSchema['limelight_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Limelight'), 'required' => false));

    $this->widgetSchema->setNameFormat('limelight_core_spec[%s]');
  }

  public function getModelName()
  {
    return 'LimelightCoreSpec';
  }

}
