<?php

/**
 * UserReviewFavorite form base class.
 *
 * @method UserReviewFavorite getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUserReviewFavoriteForm extends FavoriteForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('user_review_favorite[%s]');
  }

  public function getModelName()
  {
    return 'UserReviewFavorite';
  }

}
