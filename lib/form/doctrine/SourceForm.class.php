<?php

sfProjectConfiguration::getActive()->loadHelpers('Url');

/**
 * Source form.
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class SourceForm extends BaseLimelightForm
{
  public function configure()
  {
    $this->useFields(array('name'));

    $this->setWidgets(array(
      'name'   => new sfWidgetFormInputText(array(),
        array(
          'class'     => 'source_name rnd_3',
          'maxlength' => 50,
          'data-searchahead' => url_for('populate_sources_ac'),
          'data-searchloaded' => '0'
        )),
    ));

    $this->setValidators(array(
      'name'          => new sfValidatorString(array('trim' => true, 'required' => true, 'min_length' => 3, 'max_length' => 50)),
    ));

    $this->setWidget('source_name', $this->getWidget('name'));
    unset($this['name']);

    $this->widgetSchema->setNameFormat('source[%s]');
  }
}
