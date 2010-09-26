<?php

/**
 * LimelightReviewUser form.
 *
 * @package    form
 * @subpackage LimelightReviewUser
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class LimelightReviewUserForm extends BaseLimelightReviewUserForm
{
  public function configure()
  {
    unset(
      $this['user_id'],
      $this['limelight_id'],
      $this['score'],
      $this['status'],
      $this['review_score'],
      $this['created_at'],
      $this['updated_at']
    );

    $this->setWidgets(array(
      'title'   => new sfWidgetFormInputText(array(),
        array(
          'class'     => 'length_counter required rnd_5',
          'maxlength' => sfConfig::get('app_reviews_title_max_length')
        )),
      'content' => new sfWidgetFormTextarea(array(), array('class' => 'length_counter required rnd_3', 'maxlength' => sfConfig::get('app_reviews_content_max_length'))),
    ));

    $this->setValidators(array(
      'title' => new sfValidatorString(array('trim' => true, 'max_length' => sfConfig::get('app_reviews_title_max_length')), array('required' => 'Title is required.')),
      'content' => new sfValidatorString(array('trim' => true, 'max_length' => sfConfig::get('app_reviews_content_max_length')), array('required' => 'Content is required.')),
    ));

    $this->widgetSchema->setNameFormat('limelight_user_review[%s]');

    $this->widgetSchema->setLabels(array(
      'title' => 'Title',
      'content' => 'Content',
    ));

    /*
    $profile = new ProfileForm();
    $this->mergeForm($profile);
     */
  }
}