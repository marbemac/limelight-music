<?php

/**
 * NewsTagScore form base class.
 *
 * @method NewsTagScore getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseNewsTagScoreForm extends ScoreForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('news_tag_score[%s]');
  }

  public function getModelName()
  {
    return 'NewsTagScore';
  }

}
