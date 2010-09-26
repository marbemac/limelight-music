<?php

/**
 * LimelightReviewUser form base class.
 *
 * @method LimelightReviewUser getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLimelightReviewUserForm extends ItemForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['item_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Item'), 'add_empty' => true));
    $this->validatorSchema['item_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Item'), 'required' => false));

    $this->widgetSchema   ['title'] = new sfWidgetFormInputText();
    $this->validatorSchema['title'] = new sfValidatorString(array('max_length' => 255, 'required' => false));

    $this->widgetSchema   ['content'] = new sfWidgetFormTextarea();
    $this->validatorSchema['content'] = new sfValidatorString(array('max_length' => 1000, 'required' => false));

    $this->widgetSchema   ['score'] = new sfWidgetFormInputText();
    $this->validatorSchema['score'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['review_score'] = new sfWidgetFormInputText();
    $this->validatorSchema['review_score'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['edited'] = new sfWidgetFormInputText();
    $this->validatorSchema['edited'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema->setNameFormat('limelight_review_user[%s]');
  }

  public function getModelName()
  {
    return 'LimelightReviewUser';
  }

}
