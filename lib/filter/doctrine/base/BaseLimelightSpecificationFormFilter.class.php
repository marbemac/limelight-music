<?php

/**
 * LimelightSpecification filter form base class.
 *
 * @package    limelight
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseLimelightSpecificationFormFilter extends ItemFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['content'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['content'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['score'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['score'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['source_url'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['source_url'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['source_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Source'), 'add_empty' => true));
    $this->validatorSchema['source_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Source'), 'column' => 'id'));

    $this->widgetSchema   ['specification_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Specification'), 'add_empty' => true));
    $this->validatorSchema['specification_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Specification'), 'column' => 'id'));

    $this->widgetSchema   ['item_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Item'), 'add_empty' => true));
    $this->validatorSchema['item_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Item'), 'column' => 'id'));

    $this->widgetSchema   ['content_slug'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['content_slug'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema->setNameFormat('limelight_specification_filters[%s]');
  }

  public function getModelName()
  {
    return 'LimelightSpecification';
  }

  public function getFields()
  {
    return array_merge(parent::getFields(), array(
      'content' => 'Text',
      'score' => 'Number',
      'source_url' => 'Text',
      'source_id' => 'ForeignKey',
      'specification_id' => 'ForeignKey',
      'item_id' => 'ForeignKey',
      'content_slug' => 'Text',
    ));
  }
}
