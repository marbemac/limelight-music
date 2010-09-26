<?php

/**
 * NewsAction filter form base class.
 *
 * @package    limelight
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseNewsActionFormFilter extends UserActionFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['news_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('News'), 'add_empty' => true));
    $this->validatorSchema['news_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('News'), 'column' => 'id'));

    $this->widgetSchema->setNameFormat('news_action_filters[%s]');
  }

  public function getModelName()
  {
    return 'NewsAction';
  }

  public function getFields()
  {
    return array_merge(parent::getFields(), array(
      'news_id' => 'ForeignKey',
    ));
  }
}
