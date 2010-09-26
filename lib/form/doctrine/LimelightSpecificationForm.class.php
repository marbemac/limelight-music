<?php

/**
 * LimelightSpecification form.
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class LimelightSpecificationForm extends BaseLimelightSpecificationForm
{
  /**
   * @see ItemForm
   */

  private $ll_id;
  private $ll_name;

  public function __construct($ll_id, $ll_name=null)
  {
    $this->ll_name = $ll_name;
    $this->ll_id = $ll_id;
    parent::__construct();
  }

  public function configure()
  {
    $this->useFields(array('content', 'source_url'));

    $this->setWidgets(array(
      'content' => new sfWidgetFormInputText(array(),
        array(
          'class'     => 'rnd_3',
          'maxlength' => 50,
        )),
      'source_url'   => new sfWidgetFormInputText(array(),
        array(
          'class'     => 'rnd_3',
          'maxlength' => 100,
        )),
        'slices' => new sfWidgetFormSelect(array('choices' => Doctrine::getTable('Limelight')->getSlices($this->ll_id, $this->ll_name, true)))
    ));

    $this->setValidators(array(
      'content'       => new sfValidatorString(array('trim' => true, 'required' => true, 'min_length' => 1, 'max_length' => 50)),
      'source_url'    => new sfValidatorUrl(array('trim' => true, 'required' => false, 'min_length' => 5, 'max_length' => 100)),
      'slices' => new sfValidatorChoice(array('choices' => array_keys(Doctrine::getTable('Limelight')->getSlices($this->ll_id, $this->ll_name, true))))
    ));


    $specification = new SpecificationForm();
    $this->mergeForm($specification);
    $source = new SourceForm();
    $this->mergeForm($source);

    $this->validatorSchema->setOption('allow_extra_fields', true);

    $this->widgetSchema->setNameFormat('specification[%s]');
  }
}
