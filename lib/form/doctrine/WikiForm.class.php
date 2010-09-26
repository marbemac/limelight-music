<?php

/**
 * Wiki form.
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class WikiForm extends BaseWikiForm
{
  /**
   * @see ItemForm
   */
//  public function configure()
//  {
//    parent::configure();
//  }

  public function configure()
  {
    $this->useFields(array('topics', 'content'));

    $this->setWidgets(array(
      'topics'    => new sfWidgetFormInputText(),
      'content'    => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'topics'    => new sfValidatorString(array('trim' => true, 'required' => true, 'min_length' => 2, 'max_length' => 200), array('required' => 'You must input at least one topic keyword.')),
      'topics'    => new sfValidatorString(array('trim' => true, 'required' => true, 'min_length' => 10, 'max_length' => 15000), array('required' => 'You must write the actual wiki segment!')),
    ));

    $this->validatorSchema->setOption('allow_extra_fields', true);
  }
}
