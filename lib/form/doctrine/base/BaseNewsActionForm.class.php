<?php

/**
 * NewsAction form base class.
 *
 * @method NewsAction getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseNewsActionForm extends UserActionForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['news_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('News'), 'add_empty' => true));
    $this->validatorSchema['news_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('News'), 'required' => false));

    $this->widgetSchema->setNameFormat('news_action[%s]');
  }

  public function getModelName()
  {
    return 'NewsAction';
  }

}
