<?php

/**
 * Limelight form base class.
 *
 * @method Limelight getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLimelightForm extends ItemForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['name'] = new sfWidgetFormInputText();
    $this->validatorSchema['name'] = new sfValidatorString(array('max_length' => 255));

    $this->widgetSchema   ['score'] = new sfWidgetFormInputText();
    $this->validatorSchema['score'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['profile_image'] = new sfWidgetFormInputText();
    $this->validatorSchema['profile_image'] = new sfValidatorString(array('max_length' => 255, 'required' => false));

    $this->widgetSchema   ['total_views'] = new sfWidgetFormInputText();
    $this->validatorSchema['total_views'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['total_plays'] = new sfWidgetFormInputText();
    $this->validatorSchema['total_plays'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['favorited_count'] = new sfWidgetFormInputText();
    $this->validatorSchema['favorited_count'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['favorite_badge_flag'] = new sfWidgetFormInputText();
    $this->validatorSchema['favorite_badge_flag'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['reviewable'] = new sfWidgetFormInputText();
    $this->validatorSchema['reviewable'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['wiki_lock'] = new sfWidgetFormInputText();
    $this->validatorSchema['wiki_lock'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['spec_lock'] = new sfWidgetFormInputText();
    $this->validatorSchema['spec_lock'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['procon_lock'] = new sfWidgetFormInputText();
    $this->validatorSchema['procon_lock'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['module_specifications'] = new sfWidgetFormInputText();
    $this->validatorSchema['module_specifications'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['module_features'] = new sfWidgetFormInputText();
    $this->validatorSchema['module_features'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['module_procon'] = new sfWidgetFormInputText();
    $this->validatorSchema['module_procon'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['module_products'] = new sfWidgetFormInputText();
    $this->validatorSchema['module_products'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['limelight_type'] = new sfWidgetFormChoice(array('choices' => array('product' => 'product', 'technology' => 'technology', 'company' => 'company', 'source' => 'source', 'artist' => 'artist')));
    $this->validatorSchema['limelight_type'] = new sfValidatorChoice(array('choices' => array(0 => 'product', 1 => 'technology', 2 => 'company', 3 => 'source', 4 => 'artist'), 'required' => false));

    $this->widgetSchema   ['site'] = new sfWidgetFormChoice(array('choices' => array('tech' => 'tech', 'music' => 'music')));
    $this->validatorSchema['site'] = new sfValidatorChoice(array('choices' => array(0 => 'tech', 1 => 'music'), 'required' => false));

    $this->widgetSchema   ['company_name'] = new sfWidgetFormInputText();
    $this->validatorSchema['company_name'] = new sfValidatorString(array('max_length' => 255, 'required' => false));

    $this->widgetSchema   ['company_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Company'), 'add_empty' => true));
    $this->validatorSchema['company_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Company'), 'required' => false));

    $this->widgetSchema   ['is_stub'] = new sfWidgetFormInputText();
    $this->validatorSchema['is_stub'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['name_slug'] = new sfWidgetFormInputText();
    $this->validatorSchema['name_slug'] = new sfValidatorString(array('max_length' => 255, 'required' => false));

    $this->widgetSchema   ['categories_list'] = new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Category'));
    $this->validatorSchema['categories_list'] = new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Category', 'required' => false));

    $this->widgetSchema   ['newss_list'] = new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'News'));
    $this->validatorSchema['newss_list'] = new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'News', 'required' => false));

    $this->widgetSchema   ['songs_list'] = new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Song'));
    $this->validatorSchema['songs_list'] = new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Song', 'required' => false));

    $this->widgetSchema   ['wikis_list'] = new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Wiki'));
    $this->validatorSchema['wikis_list'] = new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Wiki', 'required' => false));

    $this->widgetSchema   ['followers_list'] = new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser'));
    $this->validatorSchema['followers_list'] = new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser', 'required' => false));

    $this->widgetSchema->setNameFormat('limelight[%s]');
  }

  public function getModelName()
  {
    return 'Limelight';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['categories_list']))
    {
      $this->setDefault('categories_list', $this->object->Categories->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['newss_list']))
    {
      $this->setDefault('newss_list', $this->object->Newss->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['songs_list']))
    {
      $this->setDefault('songs_list', $this->object->Songs->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['wikis_list']))
    {
      $this->setDefault('wikis_list', $this->object->Wikis->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['followers_list']))
    {
      $this->setDefault('followers_list', $this->object->Followers->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveCategoriesList($con);
    $this->saveNewssList($con);
    $this->saveSongsList($con);
    $this->saveWikisList($con);
    $this->saveFollowersList($con);

    parent::doSave($con);
  }

  public function saveCategoriesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['categories_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Categories->getPrimaryKeys();
    $values = $this->getValue('categories_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Categories', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Categories', array_values($link));
    }
  }

  public function saveNewssList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['newss_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Newss->getPrimaryKeys();
    $values = $this->getValue('newss_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Newss', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Newss', array_values($link));
    }
  }

  public function saveSongsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['songs_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Songs->getPrimaryKeys();
    $values = $this->getValue('songs_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Songs', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Songs', array_values($link));
    }
  }

  public function saveWikisList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['wikis_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Wikis->getPrimaryKeys();
    $values = $this->getValue('wikis_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Wikis', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Wikis', array_values($link));
    }
  }

  public function saveFollowersList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['followers_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Followers->getPrimaryKeys();
    $values = $this->getValue('followers_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Followers', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Followers', array_values($link));
    }
  }

}
