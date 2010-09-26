<?php

/**
 * LimelightProCon filter form base class.
 *
 * @package    limelight
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseLimelightProConFormFilter extends ItemFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['name'] = new sfWidgetFormFilterInput(array('with_empty' => false));
    $this->validatorSchema['name'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['score'] = new sfWidgetFormFilterInput(array('with_empty' => false));
    $this->validatorSchema['score'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['type'] = new sfWidgetFormChoice(array('choices' => array('' => '', 'pro' => 'pro', 'con' => 'con')));
    $this->validatorSchema['type'] = new sfValidatorChoice(array('required' => false, 'choices' => array('pro' => 'pro', 'con' => 'con')));

    $this->widgetSchema   ['item_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Item'), 'add_empty' => true));
    $this->validatorSchema['item_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Item'), 'column' => 'id'));

    $this->widgetSchema   ['name_slug'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['name_slug'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema->setNameFormat('limelight_pro_con_filters[%s]');
  }

  public function getModelName()
  {
    return 'LimelightProCon';
  }

  public function getFields()
  {
    return array_merge(parent::getFields(), array(
      'name' => 'Text',
      'score' => 'Number',
      'type' => 'Enum',
      'item_id' => 'ForeignKey',
      'name_slug' => 'Text',
    ));
  }
}
