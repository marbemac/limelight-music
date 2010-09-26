<?php

/**
 * WikiFlag form base class.
 *
 * @method WikiFlag getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseWikiFlagForm extends FlagForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('wiki_flag[%s]');
  }

  public function getModelName()
  {
    return 'WikiFlag';
  }

}
