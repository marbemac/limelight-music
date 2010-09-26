<?php

/**
 * Link form base class.
 *
 * @method Link getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLinkForm extends ItemForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['source_name'] = new sfWidgetFormInputText();
    $this->validatorSchema['source_name'] = new sfValidatorString(array('max_length' => 50, 'required' => false));

    $this->widgetSchema   ['source_url'] = new sfWidgetFormInputText();
    $this->validatorSchema['source_url'] = new sfValidatorString(array('max_length' => 255, 'required' => false));

    $this->widgetSchema   ['count'] = new sfWidgetFormInputText();
    $this->validatorSchema['count'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['score'] = new sfWidgetFormInputText();
    $this->validatorSchema['score'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['item_id'] = new sfWidgetFormInputText();
    $this->validatorSchema['item_id'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['link_id'] = new sfWidgetFormInputText();
    $this->validatorSchema['link_id'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['source_name_slug'] = new sfWidgetFormInputText();
    $this->validatorSchema['source_name_slug'] = new sfValidatorString(array('max_length' => 255, 'required' => false));

    $this->widgetSchema->setNameFormat('link[%s]');
  }

  public function getModelName()
  {
    return 'Link';
  }

}
