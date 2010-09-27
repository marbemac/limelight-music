<?php

/**
 * Song filter form base class.
 *
 * @package    limelight
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseSongFormFilter extends ItemFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['name'] = new sfWidgetFormFilterInput(array('with_empty' => false));
    $this->validatorSchema['name'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['content'] = new sfWidgetFormFilterInput(array('with_empty' => false));
    $this->validatorSchema['content'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['song_image'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['song_image'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['score'] = new sfWidgetFormFilterInput(array('with_empty' => false));
    $this->validatorSchema['score'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['total_plays'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['total_plays'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['favorited_count'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['favorited_count'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['favorite_badge_flag'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['favorite_badge_flag'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['tag_lock'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['tag_lock'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['comment_lock'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['comment_lock'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['name_slug'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['name_slug'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['limelights_list'] = new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Limelight'));
    $this->validatorSchema['limelights_list'] = new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Limelight', 'required' => false));

    $this->widgetSchema->setNameFormat('song_filters[%s]');
  }

  public function addLimelightsListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.LimelightSong LimelightSong')
      ->andWhereIn('LimelightSong.limelight_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Song';
  }

  public function getFields()
  {
    return array_merge(parent::getFields(), array(
      'name' => 'Text',
      'content' => 'Text',
      'song_image' => 'Text',
      'score' => 'Number',
      'total_plays' => 'Number',
      'favorited_count' => 'Number',
      'favorite_badge_flag' => 'Number',
      'tag_lock' => 'Number',
      'comment_lock' => 'Number',
      'name_slug' => 'Text',
      'limelights_list' => 'ManyKey',
    ));
  }
}
