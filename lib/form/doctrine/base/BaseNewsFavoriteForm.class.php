<?php

/**
 * NewsFavorite form base class.
 *
 * @method NewsFavorite getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseNewsFavoriteForm extends FavoriteForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('news_favorite[%s]');
  }

  public function getModelName()
  {
    return 'NewsFavorite';
  }

}
