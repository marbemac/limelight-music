<?php

/**
 * LimelightAction form base class.
 *
 * @method LimelightAction getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseLimelightActionForm extends UserActionForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['limelight_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Limelight'), 'add_empty' => true));
    $this->validatorSchema['limelight_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Limelight'), 'required' => false));

    $this->widgetSchema->setNameFormat('limelight_action[%s]');
  }

  public function getModelName()
  {
    return 'LimelightAction';
  }

}
