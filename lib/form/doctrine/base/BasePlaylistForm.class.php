<?php

/**
 * Playlist form base class.
 *
 * @method Playlist getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePlaylistForm extends ItemForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['name'] = new sfWidgetFormInputText();
    $this->validatorSchema['name'] = new sfValidatorString(array('max_length' => 255));

    $this->widgetSchema   ['score'] = new sfWidgetFormInputText();
    $this->validatorSchema['score'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['total_plays'] = new sfWidgetFormInputText();
    $this->validatorSchema['total_plays'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['favorited_count'] = new sfWidgetFormInputText();
    $this->validatorSchema['favorited_count'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['favorite_badge_flag'] = new sfWidgetFormInputText();
    $this->validatorSchema['favorite_badge_flag'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['name_slug'] = new sfWidgetFormInputText();
    $this->validatorSchema['name_slug'] = new sfValidatorString(array('max_length' => 255, 'required' => false));

    $this->widgetSchema->setNameFormat('playlist[%s]');
  }

  public function getModelName()
  {
    return 'Playlist';
  }

}
