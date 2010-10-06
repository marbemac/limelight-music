<?php

/**
 * PlaylistSong form base class.
 *
 * @method PlaylistSong getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePlaylistSongForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'playlist_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Playlist'), 'add_empty' => true)),
      'song_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Song'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'playlist_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Playlist'), 'required' => false)),
      'song_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Song'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('playlist_song[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PlaylistSong';
  }

}
