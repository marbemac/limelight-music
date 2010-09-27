<?php

/**
 * LimelightSong filter form base class.
 *
 * @package    limelight
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseLimelightSongFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'limelight_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Limelight'), 'add_empty' => true)),
      'song_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Song'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'limelight_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Limelight'), 'column' => 'id')),
      'song_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Song'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('limelight_song_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LimelightSong';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'limelight_id' => 'ForeignKey',
      'song_id'      => 'ForeignKey',
    );
  }
}
