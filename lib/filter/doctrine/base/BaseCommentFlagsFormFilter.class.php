<?php

/**
 * CommentFlags filter form base class.
 *
 * @package    limelight
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCommentFlagsFormFilter extends FlagFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['comment_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Comment'), 'add_empty' => true));
    $this->validatorSchema['comment_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Comment'), 'column' => 'id'));

    $this->widgetSchema->setNameFormat('comment_flags_filters[%s]');
  }

  public function getModelName()
  {
    return 'CommentFlags';
  }

  public function getFields()
  {
    return array_merge(parent::getFields(), array(
      'comment_id' => 'ForeignKey',
    ));
  }
}
