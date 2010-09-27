<?php

/**
 * SongScore form base class.
 *
 * @method SongScore getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSongScoreForm extends ScoreForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('song_score[%s]');
  }

  public function getModelName()
  {
    return 'SongScore';
  }

}
