<?php

/**
 * LimelightProCon form.
 *
 * @package    form
 * @subpackage LimelightProCon
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class LimelightProConForm extends BaseLimelightProConForm
{
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
    $this->useFields(array('name'));

    $this->setWidgets(array(
      'name' => new sfWidgetFormTextarea(array(), array('class' => 'length_counter rnd_3', 'maxlength' => sfConfig::get('app_limelight_procon_max_length'), 'data-searchloaded' => '0')),
      'slices' => new sfWidgetFormSelect(array('choices' => Doctrine::getTable('Limelight')->getSlices($this->ll_id, $this->ll_name, true)))
    ));

    $this->setValidators(array(
      'name' => new sfValidatorString(array('trim' => true, 'required' => true, 'min_length' => 5, 'max_length' => sfConfig::get('app_limelight_procon_max_length')), array('required' => 'Your pro/con can\'t be blank')),
      'slices' => new sfValidatorChoice(array('choices' => array_keys(Doctrine::getTable('Limelight')->getSlices($this->ll_id, $this->ll_name, true))))
    ));

    $query = Doctrine_Query::create()
      ->from('Author a')
      ->where('a.active = ?', true);
    $q = Doctrine_Query::create()
      ->select('id, name')
      ->from('LimelightSlice')
      ->where('item_id = ?', $this->ll_id)
      ->useResultCache(true, 300, 'limelight_slices_'.$this->ll_id);

    $this->validatorSchema->setOption('allow_extra_fields', true);
    $this->widgetSchema->setNameFormat('limelight_procon[%s]');
  }
}