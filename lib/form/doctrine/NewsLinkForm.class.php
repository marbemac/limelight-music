<?php

/**
 * NewsLink form.
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class NewsLinkForm extends BaseNewsLinkForm
{
  public function configure()
  {
    unset($this['id']);

    $link = new SourceForm();
    $this->mergeForm($link);
    
    $this->useFields(array('source_name', 'source_url'));

    $this->setValidators(array(
      'source_url'    => new sfValidatorUrl(),
    ));

    $this->validatorSchema->setOption('allow_extra_fields', true);
  }
}
