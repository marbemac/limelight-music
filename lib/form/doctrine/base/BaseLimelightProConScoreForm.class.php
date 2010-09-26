<?php

/**
 * LimelightProConScore form base class.
 *
 * @method LimelightProConScore getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLimelightProConScoreForm extends ScoreForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('limelight_pro_con_score[%s]');
  }

  public function getModelName()
  {
    return 'LimelightProConScore';
  }

}
