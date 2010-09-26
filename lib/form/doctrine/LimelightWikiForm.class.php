<?php

/**
 * LimelightWiki form.
 *
 * @package    form
 * @subpackage LimelightWiki
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class LimelightWikiForm extends BaseLimelightWikiForm
{
  public function configure()
  {
    unset(
      $this['active'],
      $this['sf_guard_user_id'],
      $this['created_at'],
      $this['updated_at'],
      $this['version']
    );

    $this->disableCSRFProtection();

    $this->setWidgets(array(
      'limelight_id' => new sfWidgetFormInputHidden(array(), array('readonly' => 'true')),
      'id'           => new sfWidgetFormInputHidden(array(), array('readonly' => 'true')),
      'note'         => new sfWidgetFormInputText(array(), array('maxlength' => 250))
    ));

    $this->setValidator('note', new sfValidatorString(array('required' => false, 'max_length' => 250)));
    $this->setValidator('content', new sfValidatorString(array('min_length' => 10)));

    $this->widgetSchema['content'] =  new sfWidgetFormTextareaTinyMCE(
      array(
        'width'   => 715,
        'height'  => 500,
        'config'  => 'theme_advanced_disable: "help"',
        'theme'   =>  sfConfig::get('app_tinymce_theme','advanced'),
      ),
      array(
        'class'   =>  'wiki_tiny_mce',
      )
    );

    $js_path = sfConfig::get('sf_rich_text_js_dir') ? '/'.sfConfig::get('sf_rich_text_js_dir').'/tiny_mce.js' : '/sf/tinymce/js/tiny_mce.js';
    sfContext::getInstance()->getResponse()->addJavascript($js_path);

    $this->widgetSchema->setNameFormat('wiki[%s]');
  }
}