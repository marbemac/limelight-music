<?php

/**
 * sfGuardUser form base class.
 *
 * @method sfGuardUser getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasesfGuardUserForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                        => new sfWidgetFormInputHidden(),
      'username'                  => new sfWidgetFormInputText(),
      'algorithm'                 => new sfWidgetFormInputText(),
      'salt'                      => new sfWidgetFormInputText(),
      'password'                  => new sfWidgetFormInputText(),
      'is_active'                 => new sfWidgetFormInputCheckbox(),
      'is_super_admin'            => new sfWidgetFormInputCheckbox(),
      'last_login'                => new sfWidgetFormDateTime(),
      'rpx_identifier'            => new sfWidgetFormInputText(),
      'rpx_provider_name'         => new sfWidgetFormInputText(),
      'username_changed'          => new sfWidgetFormInputText(),
      'show_help'                 => new sfWidgetFormInputText(),
      'show_welcome_splash'       => new sfWidgetFormInputText(),
      'created_at'                => new sfWidgetFormDateTime(),
      'updated_at'                => new sfWidgetFormDateTime(),
      'groups_list'               => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardGroup')),
      'permissions_list'          => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardPermission')),
      'following_users_list'      => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser')),
      'following_limelights_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Limelight')),
      'followers_list'            => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser')),
    ));

    $this->setValidators(array(
      'id'                        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'username'                  => new sfValidatorString(array('max_length' => 128)),
      'algorithm'                 => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'salt'                      => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'password'                  => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'is_active'                 => new sfValidatorBoolean(array('required' => false)),
      'is_super_admin'            => new sfValidatorBoolean(array('required' => false)),
      'last_login'                => new sfValidatorDateTime(array('required' => false)),
      'rpx_identifier'            => new sfValidatorPass(array('required' => false)),
      'rpx_provider_name'         => new sfValidatorPass(array('required' => false)),
      'username_changed'          => new sfValidatorPass(array('required' => false)),
      'show_help'                 => new sfValidatorPass(array('required' => false)),
      'show_welcome_splash'       => new sfValidatorPass(array('required' => false)),
      'created_at'                => new sfValidatorDateTime(),
      'updated_at'                => new sfValidatorDateTime(),
      'groups_list'               => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardGroup', 'required' => false)),
      'permissions_list'          => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardPermission', 'required' => false)),
      'following_users_list'      => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser', 'required' => false)),
      'following_limelights_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Limelight', 'required' => false)),
      'followers_list'            => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'sfGuardUser', 'column' => array('username'))),
        new sfValidatorDoctrineUnique(array('model' => 'sfGuardUser', 'column' => array('rpx_identifier'))),
      ))
    );

    $this->widgetSchema->setNameFormat('sf_guard_user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'sfGuardUser';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['groups_list']))
    {
      $this->setDefault('groups_list', $this->object->groups->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['permissions_list']))
    {
      $this->setDefault('permissions_list', $this->object->permissions->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['following_users_list']))
    {
      $this->setDefault('following_users_list', $this->object->FollowingUsers->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['following_limelights_list']))
    {
      $this->setDefault('following_limelights_list', $this->object->FollowingLimelights->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['followers_list']))
    {
      $this->setDefault('followers_list', $this->object->Followers->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->savegroupsList($con);
    $this->savepermissionsList($con);
    $this->saveFollowingUsersList($con);
    $this->saveFollowingLimelightsList($con);
    $this->saveFollowersList($con);

    parent::doSave($con);
  }

  public function savegroupsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['groups_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->groups->getPrimaryKeys();
    $values = $this->getValue('groups_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('groups', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('groups', array_values($link));
    }
  }

  public function savepermissionsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['permissions_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->permissions->getPrimaryKeys();
    $values = $this->getValue('permissions_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('permissions', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('permissions', array_values($link));
    }
  }

  public function saveFollowingUsersList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['following_users_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->FollowingUsers->getPrimaryKeys();
    $values = $this->getValue('following_users_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('FollowingUsers', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('FollowingUsers', array_values($link));
    }
  }

  public function saveFollowingLimelightsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['following_limelights_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->FollowingLimelights->getPrimaryKeys();
    $values = $this->getValue('following_limelights_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('FollowingLimelights', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('FollowingLimelights', array_values($link));
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
