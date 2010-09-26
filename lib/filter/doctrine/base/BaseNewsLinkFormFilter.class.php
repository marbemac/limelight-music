<?php

/**
 * NewsLink filter form base class.
 *
 * @package    limelight
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseNewsLinkFormFilter extends ItemFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['source_url'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['source_url'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['score'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['score'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['item_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Item'), 'add_empty' => true));
    $this->validatorSchema['item_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Item'), 'column' => 'id'));

    $this->widgetSchema   ['source_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Source'), 'add_empty' => true));
    $this->validatorSchema['source_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Source'), 'column' => 'id'));

    $this->widgetSchema   ['source_url_slug'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['source_url_slug'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema->setNameFormat('news_link_filters[%s]');
  }

  public function getModelName()
  {
    return 'NewsLink';
  }

  public function getFields()
  {
    return array_merge(parent::getFields(), array(
      'source_url' => 'Text',
      'score' => 'Number',
      'item_id' => 'ForeignKey',
      'source_id' => 'ForeignKey',
      'source_url_slug' => 'Text',
    ));
  }
}
