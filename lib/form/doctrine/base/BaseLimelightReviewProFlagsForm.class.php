<?php

/**
 * LimelightReviewProFlags form base class.
 *
 * @method LimelightReviewProFlags getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseLimelightReviewProFlagsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'review_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LimelightReviewPro'), 'add_empty' => true)),
      'flag_type'  => new sfWidgetFormChoice(array('choices' => array('Duplicate' => 'Duplicate', 'Wrong Limelight' => 'Wrong Limelight', 'Spam' => 'Spam', 'Broken Link' => 'Broken Link', 'Other' => 'Other'))),
      'user_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'review_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('LimelightReviewPro'), 'required' => false)),
      'flag_type'  => new sfValidatorChoice(array('choices' => array(0 => 'Duplicate', 1 => 'Wrong Limelight', 2 => 'Spam', 3 => 'Broken Link', 4 => 'Other'), 'required' => false)),
      'user_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('limelight_review_pro_flags[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LimelightReviewProFlags';
  }

}
