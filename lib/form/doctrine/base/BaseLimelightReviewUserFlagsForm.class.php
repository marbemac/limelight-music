<?php

/**
 * LimelightReviewUserFlags form base class.
 *
 * @method LimelightReviewUserFlags getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseLimelightReviewUserFlagsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'review_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LimelightReviewUser'), 'add_empty' => true)),
      'flag_type'  => new sfWidgetFormChoice(array('choices' => array('Duplicate' => 'Duplicate', 'Spam' => 'Spam', 'Innapropriate' => 'Innapropriate', 'Other' => 'Other'))),
      'user_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'review_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('LimelightReviewUser'), 'required' => false)),
      'flag_type'  => new sfValidatorChoice(array('choices' => array(0 => 'Duplicate', 1 => 'Spam', 2 => 'Innapropriate', 3 => 'Other'), 'required' => false)),
      'user_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('limelight_review_user_flags[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LimelightReviewUserFlags';
  }

}
