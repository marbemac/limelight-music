<?php

/**
 * UserAction form base class.
 *
 * @method UserAction getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUserActionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                        => new sfWidgetFormInputHidden(),
      'Limelight_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Limelights'), 'add_empty' => true)),
      'News_id'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('News'), 'add_empty' => true)),
      'Song_id'                   => new sfWidgetFormInputText(),
      'Playlist_id'               => new sfWidgetFormInputText(),
      'Comment_id'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Comments'), 'add_empty' => true)),
      'LimelightProCon_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LimelightProcons'), 'add_empty' => true)),
      'Wiki_id'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Wikis'), 'add_empty' => true)),
      'LimelightReviewUser_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LimelightUserReviews'), 'add_empty' => true)),
      'LimelightReviewPro_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LimelightProReviews'), 'add_empty' => true)),
      'LimelightSpecification_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LimelightSpecifications'), 'add_empty' => true)),
      'ItemTag_id'                => new sfWidgetFormInputText(),
      'type'                      => new sfWidgetFormInputText(),
      'site'                      => new sfWidgetFormChoice(array('choices' => array('tech' => 'tech', 'music' => 'music'))),
      'user_id'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'status'                    => new sfWidgetFormChoice(array('choices' => array('Active' => 'Active', 'Pending' => 'Pending', 'Flagged' => 'Flagged', 'Struck' => 'Struck', 'Disabled' => 'Disabled'))),
      'created_at'                => new sfWidgetFormDateTime(),
      'updated_at'                => new sfWidgetFormDateTime(),
      'deleted_at'                => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'Limelight_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Limelights'), 'required' => false)),
      'News_id'                   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('News'), 'required' => false)),
      'Song_id'                   => new sfValidatorInteger(array('required' => false)),
      'Playlist_id'               => new sfValidatorInteger(array('required' => false)),
      'Comment_id'                => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Comments'), 'required' => false)),
      'LimelightProCon_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('LimelightProcons'), 'required' => false)),
      'Wiki_id'                   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Wikis'), 'required' => false)),
      'LimelightReviewUser_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('LimelightUserReviews'), 'required' => false)),
      'LimelightReviewPro_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('LimelightProReviews'), 'required' => false)),
      'LimelightSpecification_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('LimelightSpecifications'), 'required' => false)),
      'ItemTag_id'                => new sfValidatorInteger(array('required' => false)),
      'type'                      => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'site'                      => new sfValidatorChoice(array('choices' => array(0 => 'tech', 1 => 'music'), 'required' => false)),
      'user_id'                   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'required' => false)),
      'status'                    => new sfValidatorChoice(array('choices' => array(0 => 'Active', 1 => 'Pending', 2 => 'Flagged', 3 => 'Struck', 4 => 'Disabled'), 'required' => false)),
      'created_at'                => new sfValidatorDateTime(),
      'updated_at'                => new sfValidatorDateTime(),
      'deleted_at'                => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_action[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserAction';
  }

}
