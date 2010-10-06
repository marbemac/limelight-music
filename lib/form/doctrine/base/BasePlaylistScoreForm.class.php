<?php

/**
 * PlaylistScore form base class.
 *
 * @method PlaylistScore getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePlaylistScoreForm extends ScoreForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('playlist_score[%s]');
  }

  public function getModelName()
  {
    return 'PlaylistScore';
  }

}
