<?php

/**
 * News filter form base class.
 *
 * @package    limelight
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseNewsFormFilter extends ItemFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['title'] = new sfWidgetFormFilterInput(array('with_empty' => false));
    $this->validatorSchema['title'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['content'] = new sfWidgetFormFilterInput(array('with_empty' => false));
    $this->validatorSchema['content'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['news_image'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['news_image'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['score'] = new sfWidgetFormFilterInput(array('with_empty' => false));
    $this->validatorSchema['score'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['total_views'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['total_views'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['favorited_count'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['favorited_count'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['favorite_badge_flag'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['favorite_badge_flag'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['tag_lock'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['tag_lock'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['comment_lock'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['comment_lock'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['title_slug'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['title_slug'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['limelights_list'] = new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Limelight'));
    $this->validatorSchema['limelights_list'] = new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Limelight', 'required' => false));

    $this->widgetSchema->setNameFormat('news_filters[%s]');
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
      ->leftJoin($query->getRootAlias().'.LimelightNews LimelightNews')
      ->andWhereIn('LimelightNews.limelight_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'News';
  }

  public function getFields()
  {
    return array_merge(parent::getFields(), array(
      'title' => 'Text',
      'content' => 'Text',
      'news_image' => 'Text',
      'score' => 'Number',
      'total_views' => 'Number',
      'favorited_count' => 'Number',
      'favorite_badge_flag' => 'Number',
      'tag_lock' => 'Number',
      'comment_lock' => 'Number',
      'title_slug' => 'Text',
      'limelights_list' => 'ManyKey',
    ));
  }
}
