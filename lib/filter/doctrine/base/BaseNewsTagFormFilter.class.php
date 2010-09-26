<?php

/**
 * NewsTag filter form base class.
 *
 * @package    limelight
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseNewsTagFormFilter extends ItemFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['score'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['score'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['tag_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Tag'), 'add_empty' => true));
    $this->validatorSchema['tag_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Tag'), 'column' => 'id'));

    $this->widgetSchema   ['item_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Item'), 'add_empty' => true));
    $this->validatorSchema['item_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Item'), 'column' => 'id'));

    $this->widgetSchema->setNameFormat('news_tag_filters[%s]');
  }

  public function getModelName()
  {
    return 'NewsTag';
  }

  public function getFields()
  {
    return array_merge(parent::getFields(), array(
      'score' => 'Number',
      'tag_id' => 'ForeignKey',
      'item_id' => 'ForeignKey',
    ));
  }
}
