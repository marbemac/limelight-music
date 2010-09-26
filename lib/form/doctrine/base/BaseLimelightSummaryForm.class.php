<?php

/**
 * LimelightSummary form base class.
 *
 * @method LimelightSummary getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLimelightSummaryForm extends ItemForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['summary'] = new sfWidgetFormTextarea();
    $this->validatorSchema['summary'] = new sfValidatorString(array('max_length' => 500, 'required' => false));

    $this->widgetSchema   ['version'] = new sfWidgetFormInputText();
    $this->validatorSchema['version'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['is_active'] = new sfWidgetFormInputText();
    $this->validatorSchema['is_active'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['item_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Limelight'), 'add_empty' => true));
    $this->validatorSchema['item_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Limelight'), 'required' => false));

    $this->widgetSchema->setNameFormat('limelight_summary[%s]');
  }

  public function getModelName()
  {
    return 'LimelightSummary';
  }

}
