<?php

/**
 * SongView form base class.
 *
 * @method SongView getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSongViewForm extends ViewForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['item_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Item'), 'add_empty' => true));
    $this->validatorSchema['item_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Item'), 'required' => false));

    $this->widgetSchema->setNameFormat('song_view[%s]');
  }

  public function getModelName()
  {
    return 'SongView';
  }

}
