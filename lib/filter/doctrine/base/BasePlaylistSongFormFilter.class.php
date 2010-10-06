<?php

/**
 * PlaylistSong filter form base class.
 *
 * @package    limelight
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasePlaylistSongFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'playlist_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Playlist'), 'add_empty' => true)),
      'song_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Song'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'playlist_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Playlist'), 'column' => 'id')),
      'song_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Song'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('playlist_song_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PlaylistSong';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'playlist_id' => 'ForeignKey',
      'song_id'     => 'ForeignKey',
    );
  }
}
