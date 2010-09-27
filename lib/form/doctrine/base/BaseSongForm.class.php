<?php

/**
 * Song form base class.
 *
 * @method Song getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSongForm extends ItemForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['name'] = new sfWidgetFormInputText();
    $this->validatorSchema['name'] = new sfValidatorString(array('max_length' => 255));

    $this->widgetSchema   ['content'] = new sfWidgetFormTextarea();
    $this->validatorSchema['content'] = new sfValidatorString(array('max_length' => 2000));

    $this->widgetSchema   ['song_image'] = new sfWidgetFormInputText();
    $this->validatorSchema['song_image'] = new sfValidatorString(array('max_length' => 255, 'required' => false));

    $this->widgetSchema   ['score'] = new sfWidgetFormInputText();
    $this->validatorSchema['score'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['total_plays'] = new sfWidgetFormInputText();
    $this->validatorSchema['total_plays'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['favorited_count'] = new sfWidgetFormInputText();
    $this->validatorSchema['favorited_count'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['favorite_badge_flag'] = new sfWidgetFormInputText();
    $this->validatorSchema['favorite_badge_flag'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['tag_lock'] = new sfWidgetFormInputText();
    $this->validatorSchema['tag_lock'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['comment_lock'] = new sfWidgetFormInputText();
    $this->validatorSchema['comment_lock'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['name_slug'] = new sfWidgetFormInputText();
    $this->validatorSchema['name_slug'] = new sfValidatorString(array('max_length' => 255, 'required' => false));

    $this->widgetSchema   ['limelights_list'] = new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Limelight'));
    $this->validatorSchema['limelights_list'] = new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Limelight', 'required' => false));

    $this->widgetSchema->setNameFormat('song[%s]');
  }

  public function getModelName()
  {
    return 'Song';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['limelights_list']))
    {
      $this->setDefault('limelights_list', $this->object->Limelights->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveLimelightsList($con);

    parent::doSave($con);
  }

  public function saveLimelightsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['limelights_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Limelights->getPrimaryKeys();
    $values = $this->getValue('limelights_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Limelights', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Limelights', array_values($link));
    }
  }

}
