<?php

/**
 * LimelightSummary filter form base class.
 *
 * @package    limelight
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseLimelightSummaryFormFilter extends ItemFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['summary'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['summary'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['version'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['version'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['is_active'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['is_active'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['item_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Limelight'), 'add_empty' => true));
    $this->validatorSchema['item_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Limelight'), 'column' => 'id'));

    $this->widgetSchema->setNameFormat('limelight_summary_filters[%s]');
  }

  public function getModelName()
  {
    return 'LimelightSummary';
  }

  public function getFields()
  {
    return array_merge(parent::getFields(), array(
      'summary' => 'Text',
      'version' => 'Number',
      'is_active' => 'Text',
      'item_id' => 'ForeignKey',
    ));
  }
}
