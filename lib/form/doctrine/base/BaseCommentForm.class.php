<?php

/**
 * Comment form base class.
 *
 * @method Comment getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCommentForm extends ItemForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['content'] = new sfWidgetFormTextarea();
    $this->validatorSchema['content'] = new sfValidatorString(array('max_length' => 1000));

    $this->widgetSchema   ['score'] = new sfWidgetFormInputText();
    $this->validatorSchema['score'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['type'] = new sfWidgetFormChoice(array('choices' => array('News' => 'News', 'LimelightReviewUser' => 'LimelightReviewUser', 'LimelightReviewPro' => 'LimelightReviewPro', 'Wiki' => 'Wiki')));
    $this->validatorSchema['type'] = new sfValidatorChoice(array('choices' => array(0 => 'News', 1 => 'LimelightReviewUser', 2 => 'LimelightReviewPro', 3 => 'Wiki')));

    $this->widgetSchema   ['parent_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Parent'), 'add_empty' => true));
    $this->validatorSchema['parent_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Parent'), 'required' => false));

    $this->widgetSchema   ['edited'] = new sfWidgetFormInputText();
    $this->validatorSchema['edited'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['News_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('News'), 'add_empty' => true));
    $this->validatorSchema['News_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('News'), 'required' => false));

    $this->widgetSchema   ['Wiki_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Wiki'), 'add_empty' => true));
    $this->validatorSchema['Wiki_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Wiki'), 'required' => false));

    $this->widgetSchema   ['LimelightReviewUser_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LimelightReviewUser'), 'add_empty' => true));
    $this->validatorSchema['LimelightReviewUser_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('LimelightReviewUser'), 'required' => false));

    $this->widgetSchema   ['LimelightReviewPro_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LimelightReviewPro'), 'add_empty' => true));
    $this->validatorSchema['LimelightReviewPro_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('LimelightReviewPro'), 'required' => false));

    $this->widgetSchema->setNameFormat('comment[%s]');
  }

  public function getModelName()
  {
    return 'Comment';
  }

}
