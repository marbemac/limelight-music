<?php

/**
 * ProReviewFavorite form base class.
 *
 * @method ProReviewFavorite getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProReviewFavoriteForm extends FavoriteForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('pro_review_favorite[%s]');
  }

  public function getModelName()
  {
    return 'ProReviewFavorite';
  }

}
