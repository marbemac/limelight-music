<?php

/**
 * Playlist filter form base class.
 *
 * @package    limelight
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasePlaylistFormFilter extends ItemFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['name'] = new sfWidgetFormFilterInput(array('with_empty' => false));
    $this->validatorSchema['name'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['score'] = new sfWidgetFormFilterInput(array('with_empty' => false));
    $this->validatorSchema['score'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['total_plays'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['total_plays'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['favorited_count'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['favorited_count'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['favorite_badge_flag'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['favorite_badge_flag'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['name_slug'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['name_slug'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema->setNameFormat('playlist_filters[%s]');
  }

  public function getModelName()
  {
    return 'Playlist';
  }

  public function getFields()
  {
    return array_merge(parent::getFields(), array(
      'name' => 'Text',
      'score' => 'Number',
      'total_plays' => 'Number',
      'favorited_count' => 'Number',
      'favorite_badge_flag' => 'Number',
      'name_slug' => 'Text',
    ));
  }
}
