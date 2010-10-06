<?php

sfProjectConfiguration::getActive()->loadHelpers('Url');

/**
 * Limelight form.
 *
 * @package    form
 * @subpackage Limelight
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class LimelightForm extends BaseLimelightForm
{
  public function configure()
  {
    $this->useFields(array('name', 'company_name'));

    $this->setWidgets(array(
      'name'   => new sfWidgetFormInputText(array(),
        array(
          'class'     => 'rnd_5',
          'maxlength' => sfConfig::get('app_limelight_name_max_length'),
        )),
      'company_name'   => new sfWidgetFormInputText(array('label' => 'Company'),
        array(
          'class'     => 'rnd_5',
          'maxlength' => 40,
          'label'     => 'Company'
        )),
    ));

    $this->setValidators(array(
      'name'           => new sfValidatorString(array('trim' => true, 'required' => true, 'min_length' => 2, 'max_length' => sfConfig::get('app_limelight_name_max_length'))),
      'company_name'   => new sfValidatorString(array('trim' => true, 'required' => false, 'min_length' => 2, 'max_length' => 40)),
      'summary'        => new sfValidatorString(array('trim' => true, 'required' => false, 'min_length' => 10, 'max_length' => 275)),
    ));

    $summary = new LimelightSummaryForm();
    $this->mergeForm($summary);

//    if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1') {
//      $this->setWidget('captcha', new sfWidgetFormReCaptcha(array('public_key' => sfConfig::get('app_recaptcha_public_key'))));
//      $this->setValidator('captcha', new sfValidatorReCaptcha(array(
//        'private_key' => sfConfig::get('app_recaptcha_private_key'),
//        'remote_addr' => substr($_SERVER['REMOTE_ADDR'], 8)
//      )));
//      $this->widgetSchema->setLabel('captcha', 'Human or robot? We\'ll see...');
//    }

    $this->validatorSchema->setOption('allow_extra_fields', true);
    $this->widgetSchema->setNameFormat('limelight[%s]');
  }
}