<?php

/**
 * LimelightReviewPro filter form base class.
 *
 * @package    limelight
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseLimelightReviewProFormFilter extends ItemFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['item_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Item'), 'add_empty' => true));
    $this->validatorSchema['item_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Item'), 'column' => 'id'));

    $this->widgetSchema   ['excerpt'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['excerpt'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['source_url'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['source_url'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['score'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['score'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['review_score_given'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['review_score_given'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['review_score_max'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['review_score_max'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['source_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Source'), 'add_empty' => true));
    $this->validatorSchema['source_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Source'), 'column' => 'id'));

    $this->widgetSchema->setNameFormat('limelight_review_pro_filters[%s]');
  }

  public function getModelName()
  {
    return 'LimelightReviewPro';
  }

  public function getFields()
  {
    return array_merge(parent::getFields(), array(
      'item_id' => 'ForeignKey',
      'excerpt' => 'Text',
      'source_url' => 'Text',
      'score' => 'Number',
      'review_score_given' => 'Number',
      'review_score_max' => 'Number',
      'source_id' => 'ForeignKey',
    ));
  }
}
