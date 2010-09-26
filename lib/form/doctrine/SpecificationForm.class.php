<?php

/**
 * Specification form.
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class SpecificationForm extends BaseSpecificationForm
{
  public function configure()
  {
    $this->useFields(array('name'));

    $this->setWidgets(array(
      'name'   => new sfWidgetFormInputText(array(),
        array(
          'class'     => 'rnd_3',
          'maxlength' => 50,
        )),
    ));

    $this->setValidators(array(
      'name'          => new sfValidatorString(array('trim' => true, 'required' => true, 'min_length' => 2, 'max_length' => 50)),
    ));

    $this->widgetSchema->setNameFormat('specification[%s]');
  }
}
