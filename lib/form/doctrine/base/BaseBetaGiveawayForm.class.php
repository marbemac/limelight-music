<?php

/**
 * BetaGiveaway form base class.
 *
 * @method BetaGiveaway getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseBetaGiveawayForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'guess'         => new sfWidgetFormInputText(),
      'group_code'    => new sfWidgetFormInputText(),
      'beta_email_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('BetaEmail'), 'add_empty' => true)),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
      'deleted_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'guess'         => new sfValidatorString(array('max_length' => 255)),
      'group_code'    => new sfValidatorInteger(array('required' => false)),
      'beta_email_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('BetaEmail'), 'required' => false)),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
      'deleted_at'    => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('beta_giveaway[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'BetaGiveaway';
  }

}
