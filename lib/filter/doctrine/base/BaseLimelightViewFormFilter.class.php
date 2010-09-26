<?php

/**
 * LimelightView filter form base class.
 *
 * @package    limelight
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseLimelightViewFormFilter extends ViewFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['item_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Item'), 'add_empty' => true));
    $this->validatorSchema['item_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Item'), 'column' => 'id'));

    $this->widgetSchema->setNameFormat('limelight_view_filters[%s]');
  }

  public function getModelName()
  {
    return 'LimelightView';
  }

  public function getFields()
  {
    return array_merge(parent::getFields(), array(
      'item_id' => 'ForeignKey',
    ));
  }
}
