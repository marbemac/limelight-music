<?php

/**
 * NewsLink form base class.
 *
 * @method NewsLink getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseNewsLinkForm extends ItemForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['source_url'] = new sfWidgetFormInputText();
    $this->validatorSchema['source_url'] = new sfValidatorString(array('max_length' => 255, 'required' => false));

    $this->widgetSchema   ['score'] = new sfWidgetFormInputText();
    $this->validatorSchema['score'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['item_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Item'), 'add_empty' => true));
    $this->validatorSchema['item_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Item'), 'required' => false));

    $this->widgetSchema   ['source_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Source'), 'add_empty' => true));
    $this->validatorSchema['source_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Source'), 'required' => false));

    $this->widgetSchema   ['source_url_slug'] = new sfWidgetFormInputText();
    $this->validatorSchema['source_url_slug'] = new sfValidatorString(array('max_length' => 255, 'required' => false));

    $this->widgetSchema->setNameFormat('news_link[%s]');
  }

  public function getModelName()
  {
    return 'NewsLink';
  }

}
