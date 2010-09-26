<?php

/**
 * LimelightCoreSpec filter form base class.
 *
 * @package    limelight
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseLimelightCoreSpecFormFilter extends ItemFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['name'] = new sfWidgetFormChoice(array('choices' => array('' => '', 'Manufacturer' => 'Manufacturer', 'Release Date' => 'Release Date', 'MSRP' => 'MSRP')));
    $this->validatorSchema['name'] = new sfValidatorChoice(array('required' => false, 'choices' => array('Manufacturer' => 'Manufacturer', 'Release Date' => 'Release Date', 'MSRP' => 'MSRP')));

    $this->widgetSchema   ['content'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['content'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['limelight_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Limelight'), 'add_empty' => true));
    $this->validatorSchema['limelight_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Limelight'), 'column' => 'id'));

    $this->widgetSchema->setNameFormat('limelight_core_spec_filters[%s]');
  }

  public function getModelName()
  {
    return 'LimelightCoreSpec';
  }

  public function getFields()
  {
    return array_merge(parent::getFields(), array(
      'name' => 'Enum',
      'content' => 'Text',
      'limelight_id' => 'ForeignKey',
    ));
  }
}
