<?php

/**
 * LimelightSpec filter form base class.
 *
 * @package    limelight
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseLimelightSpecFormFilter extends ItemFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['name'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['name'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['name_slug'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['name_slug'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['content'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['content'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['source_name'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['source_name'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['source_url'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['source_url'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['limelight_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Limelight'), 'add_empty' => true));
    $this->validatorSchema['limelight_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Limelight'), 'column' => 'id'));

    $this->widgetSchema->setNameFormat('limelight_spec_filters[%s]');
  }

  public function getModelName()
  {
    return 'LimelightSpec';
  }

  public function getFields()
  {
    return array_merge(parent::getFields(), array(
      'name' => 'Text',
      'name_slug' => 'Text',
      'content' => 'Text',
      'source_name' => 'Text',
      'source_url' => 'Text',
      'limelight_id' => 'ForeignKey',
    ));
  }
}
