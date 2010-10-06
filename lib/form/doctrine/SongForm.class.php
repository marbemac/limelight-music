<?php

/**
 * Song form.
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class SongForm extends BaseSongForm
{
  /**
   * @see ItemForm
   */
  public function configure()
  {
    $this->useFields(array('name', 'content', 'filename'));

    $this->setWidgets(array(
      'name'   => new sfWidgetFormInputText(array(),
        array(
          'class'     => 'rnd_5',
          'maxlength' => 100,
        )),
      'content'   => new sfWidgetFormTextarea(array(),
        array(
          'class'     => 'rnd_5',
          'maxlength' => 300,
        )),
    ));

    $this->setValidators(array(
      'name'       => new sfValidatorString(array('trim' => true, 'required' => true, 'min_length' => 1, 'max_length' => 100)),
      'content'     => new sfValidatorString(array('trim' => true, 'min_length' => 10, 'required' => false, 'max_length' => 350)),
      'filename'       => new sfValidatorString(array('trim' => true, 'required' => true, 'min_length' => 1, 'max_length' => 100)),
    ));

//    if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1') {
//      $this->setWidget('captcha', new sfWidgetFormReCaptcha(array('public_key' => sfConfig::get('app_recaptcha_public_key'))));
//      $this->setValidator('captcha', new sfValidatorReCaptcha(array(
//        'private_key' => sfConfig::get('app_recaptcha_private_key'),
//        'remote_addr' => substr($_SERVER['REMOTE_ADDR'], 8)
//      )));
//      $this->widgetSchema->setLabel('captcha', 'Human or robot? We\'ll see...');
//    }
    $this->validatorSchema->setOption('allow_extra_fields', true);
    $this->widgetSchema->setNameFormat('song[%s]');
  }
}
