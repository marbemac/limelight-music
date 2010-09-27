<?php

/**
 * ItemTagFlag form base class.
 *
 * @method ItemTagFlag getObject() Returns the current form's model object
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseItemTagFlagForm extends FlagForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('item_tag_flag[%s]');
  }

  public function getModelName()
  {
    return 'ItemTagFlag';
  }

}
