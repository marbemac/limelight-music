<?php

/**
 * NewsTag form base class.
 *
 * @method NewsTag getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseNewsTagForm extends ItemForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['score'] = new sfWidgetFormInputText();
    $this->validatorSchema['score'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['tag_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Tag'), 'add_empty' => true));
    $this->validatorSchema['tag_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Tag'), 'required' => false));

    $this->widgetSchema   ['item_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Item'), 'add_empty' => true));
    $this->validatorSchema['item_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Item'), 'required' => false));

    $this->widgetSchema->setNameFormat('news_tag[%s]');
  }

  public function getModelName()
  {
    return 'NewsTag';
  }

}
