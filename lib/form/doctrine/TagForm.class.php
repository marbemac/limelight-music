<?php

sfProjectConfiguration::getActive()->loadHelpers('Url');

/**
 * Tag form.
 *
 * @package    form
 * @subpackage Tag
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class TagForm extends BaseTagForm
{
  public function configure()
  {
    $this->useFields(array('name'));

    $this->setWidgets(array(
      'name'   => new sfWidgetFormInputText(array(),
        array(
          'class'     => 'tag_name rnd_3',
          'maxlength' => 30,
          'data-searchahead' => url_for('populate_tags_ac'),
          'data-searchloaded' => '0',
          'autocomplete' => 'off'
        )),
    ));

    $this->setValidators(array(
      'name'          => new sfValidatorString(array('trim' => true, 'required' => true, 'min_length' => 2, 'max_length' => 30)),
    ));
  }
}