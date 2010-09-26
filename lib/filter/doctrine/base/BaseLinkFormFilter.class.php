<?php

/**
 * Link filter form base class.
 *
 * @package    limelight
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseLinkFormFilter extends ItemFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['source_name'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['source_name'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['source_url'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['source_url'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['count'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['count'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['score'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['score'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['item_id'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['item_id'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['link_id'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['link_id'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['source_name_slug'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['source_name_slug'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema->setNameFormat('link_filters[%s]');
  }

  public function getModelName()
  {
    return 'Link';
  }

  public function getFields()
  {
    return array_merge(parent::getFields(), array(
      'source_name' => 'Text',
      'source_url' => 'Text',
      'count' => 'Number',
      'score' => 'Number',
      'item_id' => 'Number',
      'link_id' => 'Number',
      'source_name_slug' => 'Text',
    ));
  }
}
