<?php

/**
 * Comment filter form base class.
 *
 * @package    limelight
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCommentFormFilter extends ItemFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['content'] = new sfWidgetFormFilterInput(array('with_empty' => false));
    $this->validatorSchema['content'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['score'] = new sfWidgetFormFilterInput(array('with_empty' => false));
    $this->validatorSchema['score'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['type'] = new sfWidgetFormChoice(array('choices' => array('' => '', 'News' => 'News', 'LimelightReviewUser' => 'LimelightReviewUser', 'LimelightReviewPro' => 'LimelightReviewPro', 'Wiki' => 'Wiki')));
    $this->validatorSchema['type'] = new sfValidatorChoice(array('required' => false, 'choices' => array('News' => 'News', 'LimelightReviewUser' => 'LimelightReviewUser', 'LimelightReviewPro' => 'LimelightReviewPro', 'Wiki' => 'Wiki')));

    $this->widgetSchema   ['parent_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Parent'), 'add_empty' => true));
    $this->validatorSchema['parent_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Parent'), 'column' => 'id'));

    $this->widgetSchema   ['edited'] = new sfWidgetFormFilterInput(array('with_empty' => false));
    $this->validatorSchema['edited'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['News_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('News'), 'add_empty' => true));
    $this->validatorSchema['News_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('News'), 'column' => 'id'));

    $this->widgetSchema   ['Wiki_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Wiki'), 'add_empty' => true));
    $this->validatorSchema['Wiki_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Wiki'), 'column' => 'id'));

    $this->widgetSchema   ['LimelightReviewUser_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LimelightReviewUser'), 'add_empty' => true));
    $this->validatorSchema['LimelightReviewUser_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('LimelightReviewUser'), 'column' => 'id'));

    $this->widgetSchema   ['LimelightReviewPro_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LimelightReviewPro'), 'add_empty' => true));
    $this->validatorSchema['LimelightReviewPro_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('LimelightReviewPro'), 'column' => 'id'));

    $this->widgetSchema->setNameFormat('comment_filters[%s]');
  }

  public function getModelName()
  {
    return 'Comment';
  }

  public function getFields()
  {
    return array_merge(parent::getFields(), array(
      'content' => 'Text',
      'score' => 'Number',
      'type' => 'Enum',
      'parent_id' => 'ForeignKey',
      'edited' => 'Number',
      'News_id' => 'ForeignKey',
      'Wiki_id' => 'ForeignKey',
      'LimelightReviewUser_id' => 'ForeignKey',
      'LimelightReviewPro_id' => 'ForeignKey',
    ));
  }
}
