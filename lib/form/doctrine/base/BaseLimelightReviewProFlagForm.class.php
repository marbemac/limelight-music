<?php

/**
 * LimelightReviewProFlag form base class.
 *
 * @method LimelightReviewProFlag getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLimelightReviewProFlagForm extends FlagForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('limelight_review_pro_flag[%s]');
  }

  public function getModelName()
  {
    return 'LimelightReviewProFlag';
  }

}
