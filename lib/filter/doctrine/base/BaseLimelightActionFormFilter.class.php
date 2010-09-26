<?php

/**
 * LimelightAction filter form base class.
 *
 * @package    limelight
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseLimelightActionFormFilter extends UserActionFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['limelight_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Limelight'), 'add_empty' => true));
    $this->validatorSchema['limelight_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Limelight'), 'column' => 'id'));

    $this->widgetSchema->setNameFormat('limelight_action_filters[%s]');
  }

  public function getModelName()
  {
    return 'LimelightAction';
  }

  public function getFields()
  {
    return array_merge(parent::getFields(), array(
      'limelight_id' => 'ForeignKey',
    ));
  }
}
