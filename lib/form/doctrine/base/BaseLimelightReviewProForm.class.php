<?php

/**
 * LimelightReviewPro form base class.
 *
 * @method LimelightReviewPro getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLimelightReviewProForm extends ItemForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['item_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Item'), 'add_empty' => true));
    $this->validatorSchema['item_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Item'), 'required' => false));

    $this->widgetSchema   ['excerpt'] = new sfWidgetFormInputText();
    $this->validatorSchema['excerpt'] = new sfValidatorString(array('max_length' => 255, 'required' => false));

    $this->widgetSchema   ['source_url'] = new sfWidgetFormInputText();
    $this->validatorSchema['source_url'] = new sfValidatorString(array('max_length' => 255, 'required' => false));

    $this->widgetSchema   ['score'] = new sfWidgetFormInputText();
    $this->validatorSchema['score'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['review_score_given'] = new sfWidgetFormInputText();
    $this->validatorSchema['review_score_given'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['review_score_max'] = new sfWidgetFormInputText();
    $this->validatorSchema['review_score_max'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['source_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Source'), 'add_empty' => true));
    $this->validatorSchema['source_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Source'), 'required' => false));

    $this->widgetSchema->setNameFormat('limelight_review_pro[%s]');
  }

  public function getModelName()
  {
    return 'LimelightReviewPro';
  }

}
