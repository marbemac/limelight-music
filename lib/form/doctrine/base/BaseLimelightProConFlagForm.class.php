<?php

/**
 * LimelightProConFlag form base class.
 *
 * @method LimelightProConFlag getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLimelightProConFlagForm extends FlagForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('limelight_pro_con_flag[%s]');
  }

  public function getModelName()
  {
    return 'LimelightProConFlag';
  }

}
