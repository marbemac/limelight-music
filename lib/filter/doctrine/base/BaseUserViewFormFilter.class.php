<?php

/**
 * UserView filter form base class.
 *
 * @package    limelight
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseUserViewFormFilter extends ViewFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['target_user_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Item'), 'add_empty' => true));
    $this->validatorSchema['target_user_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Item'), 'column' => 'id'));

    $this->widgetSchema->setNameFormat('user_view_filters[%s]');
  }

  public function getModelName()
  {
    return 'UserView';
  }

  public function getFields()
  {
    return array_merge(parent::getFields(), array(
      'target_user_id' => 'ForeignKey',
    ));
  }
}
