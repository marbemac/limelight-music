<?php

/**
 * ItemTag form.
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ItemTagForm extends BaseItemTagForm
{
  public function configure()
  {
    $this->useFields(array());

    $tag = new tagForm();
    $this->mergeForm($tag);

    $this->widgetSchema->setNameFormat('itemTag[%s]');
  }
}
