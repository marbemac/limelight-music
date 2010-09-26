<?php

/**
 * LimelightProCon form base class.
 *
 * @method LimelightProCon getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLimelightProConForm extends ItemForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['name'] = new sfWidgetFormInputText();
    $this->validatorSchema['name'] = new sfValidatorString(array('max_length' => 255));

    $this->widgetSchema   ['score'] = new sfWidgetFormInputText();
    $this->validatorSchema['score'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['type'] = new sfWidgetFormChoice(array('choices' => array('pro' => 'pro', 'con' => 'con')));
    $this->validatorSchema['type'] = new sfValidatorChoice(array('choices' => array(0 => 'pro', 1 => 'con'), 'required' => false));

    $this->widgetSchema   ['item_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Item'), 'add_empty' => true));
    $this->validatorSchema['item_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Item'), 'required' => false));

    $this->widgetSchema   ['name_slug'] = new sfWidgetFormInputText();
    $this->validatorSchema['name_slug'] = new sfValidatorString(array('max_length' => 255, 'required' => false));

    $this->widgetSchema->setNameFormat('limelight_pro_con[%s]');
  }

  public function getModelName()
  {
    return 'LimelightProCon';
  }

}
