<?php

/**
 * NewsTag form.
 *
 * @package    form
 * @subpackage NewsTag
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class NewsTagForm extends BaseNewsTagForm
{
  public function configure()
  {
    $this->useFields(array());

    $tag = new tagForm();
    $this->mergeForm($tag);

    $this->widgetSchema->setNameFormat('newsTag[%s]');
  }
}