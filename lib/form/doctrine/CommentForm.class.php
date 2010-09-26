<?php

/**
 * Comment form.
 *
 * @package    form
 * @subpackage Comment
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class CommentForm extends BaseCommentForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'content'    => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'content'    => new sfValidatorString(array('trim' => true, 'required' => true, 'min_length' => 5, 'max_length' => sfConfig::get('app_comment_max_length')), array('required' => 'Comment cannot be empty.')),
    ));

    $this->widgetSchema->setNameFormat('comment[%s]');
  }
}