<?php

/**
 * Wiki form base class.
 *
 * @method Wiki getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseWikiForm extends ItemForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['topics'] = new sfWidgetFormInputText();
    $this->validatorSchema['topics'] = new sfValidatorString(array('max_length' => 255, 'required' => false));

    $this->widgetSchema   ['content'] = new sfWidgetFormTextarea();
    $this->validatorSchema['content'] = new sfValidatorString(array('required' => false));

    $this->widgetSchema   ['note'] = new sfWidgetFormInputText();
    $this->validatorSchema['note'] = new sfValidatorString(array('max_length' => 255, 'required' => false));

    $this->widgetSchema   ['version'] = new sfWidgetFormInputText();
    $this->validatorSchema['version'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['score'] = new sfWidgetFormInputText();
    $this->validatorSchema['score'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['is_active'] = new sfWidgetFormInputText();
    $this->validatorSchema['is_active'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['edit_type'] = new sfWidgetFormChoice(array('choices' => array('minor' => 'minor', 'major' => 'major')));
    $this->validatorSchema['edit_type'] = new sfValidatorChoice(array('choices' => array(0 => 'minor', 1 => 'major'), 'required' => false));

    $this->widgetSchema   ['edit_lock'] = new sfWidgetFormInputText();
    $this->validatorSchema['edit_lock'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['edit_lock_start'] = new sfWidgetFormInputText();
    $this->validatorSchema['edit_lock_start'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['edit_lock_time'] = new sfWidgetFormInputText();
    $this->validatorSchema['edit_lock_time'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['edit_lock_user_id'] = new sfWidgetFormInputText();
    $this->validatorSchema['edit_lock_user_id'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['lock_code'] = new sfWidgetFormInputText();
    $this->validatorSchema['lock_code'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['group_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LimelightWikis'), 'add_empty' => false));
    $this->validatorSchema['group_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('LimelightWikis')));

    $this->widgetSchema   ['limelights_list'] = new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Limelight'));
    $this->validatorSchema['limelights_list'] = new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Limelight', 'required' => false));

    $this->widgetSchema->setNameFormat('wiki[%s]');
  }

  public function getModelName()
  {
    return 'Wiki';
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
