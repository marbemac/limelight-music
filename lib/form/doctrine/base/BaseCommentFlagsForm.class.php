<?php

/**
 * CommentFlags form base class.
 *
 * @method CommentFlags getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCommentFlagsForm extends FlagForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['comment_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Comment'), 'add_empty' => true));
    $this->validatorSchema['comment_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Comment'), 'required' => false));

    $this->widgetSchema->setNameFormat('comment_flags[%s]');
  }

  public function getModelName()
  {
    return 'CommentFlags';
  }

}
