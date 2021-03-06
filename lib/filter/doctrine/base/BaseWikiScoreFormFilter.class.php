<?php

/**
 * WikiScore filter form base class.
 *
 * @package    limelight
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseWikiScoreFormFilter extends ScoreFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('wiki_score_filters[%s]');
  }

  public function getModelName()
  {
    return 'WikiScore';
  }
}
