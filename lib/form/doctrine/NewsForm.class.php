<?php

sfProjectConfiguration::getActive()->loadHelpers('Url');

/**
 * News form.
 *
 * @package    form
 * @subpackage News
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class NewsForm extends BaseNewsForm
{
  public function configure()
  {
    $this->useFields(array('title', 'content', 'news_image'));

    $this->setWidgets(array(
      'title'   => new sfWidgetFormInputText(array(),
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
      'title'       => new sfValidatorString(array('trim' => true, 'required' => true, 'min_length' => 5, 'max_length' => 100)),
      'content'     => new sfValidatorString(array('trim' => true, 'required' => true, 'min_length' => 10, 'max_length' => 350)),
    ));

    $newsLink = new NewsLinkForm();
    $this->mergeForm($newsLink);

//    if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1') {
//      $this->setWidget('captcha', new sfWidgetFormReCaptcha(array('public_key' => sfConfig::get('app_recaptcha_public_key'))));
//      $this->setValidator('captcha', new sfValidatorReCaptcha(array(
//        'private_key' => sfConfig::get('app_recaptcha_private_key'),
//        'remote_addr' => substr($_SERVER['REMOTE_ADDR'], 8)
//      )));
//      $this->widgetSchema->setLabel('captcha', 'Human or robot? We\'ll see...');
//    }
    $this->validatorSchema->setOption('allow_extra_fields', true);
    $this->widgetSchema->setNameFormat('news[%s]');
  }
}
