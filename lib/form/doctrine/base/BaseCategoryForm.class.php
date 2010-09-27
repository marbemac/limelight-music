<?php

/**
 * Category form base class.
 *
 * @method Category getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCategoryForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'name'            => new sfWidgetFormInputText(),
      'status'          => new sfWidgetFormChoice(array('choices' => array('Active' => 'Active', 'Pending' => 'Pending', 'Struck' => 'Struck', 'Flagged' => 'Flagged', 'Disabled' => 'Disabled'))),
      'num_limelights'  => new sfWidgetFormInputText(),
      'num_news'        => new sfWidgetFormInputText(),
      'amazon_category' => new sfWidgetFormInputText(),
      'site'            => new sfWidgetFormChoice(array('choices' => array('tech' => 'tech', 'music' => 'music'))),
      'parent_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Parent'), 'add_empty' => true)),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
      'deleted_at'      => new sfWidgetFormDateTime(),
      'name_slug'       => new sfWidgetFormInputText(),
      'limelight_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Limelight')),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'            => new sfValidatorString(array('max_length' => 255)),
      'status'          => new sfValidatorChoice(array('choices' => array(0 => 'Active', 1 => 'Pending', 2 => 'Struck', 3 => 'Flagged', 4 => 'Disabled'), 'required' => false)),
      'num_limelights'  => new sfValidatorInteger(array('required' => false)),
      'num_news'        => new sfValidatorInteger(array('required' => false)),
      'amazon_category' => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'site'            => new sfValidatorChoice(array('choices' => array(0 => 'tech', 1 => 'music'), 'required' => false)),
      'parent_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Parent'), 'required' => false)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
      'deleted_at'      => new sfValidatorDateTime(array('required' => false)),
      'name_slug'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'limelight_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Limelight', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Category', 'column' => array('name_slug')))
    );

    $this->widgetSchema->setNameFormat('category[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Category';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['limelight_list']))
    {
      $this->setDefault('limelight_list', $this->object->Limelight->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveLimelightList($con);

    parent::doSave($con);
  }

  public function saveLimelightList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['limelight_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Limelight->getPrimaryKeys();
    $values = $this->getValue('limelight_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Limelight', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Limelight', array_values($link));
    }
  }

}
