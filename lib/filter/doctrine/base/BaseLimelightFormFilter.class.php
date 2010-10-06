<?php

/**
 * Limelight filter form base class.
 *
 * @package    limelight
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseLimelightFormFilter extends ItemFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['name'] = new sfWidgetFormFilterInput(array('with_empty' => false));
    $this->validatorSchema['name'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['score'] = new sfWidgetFormFilterInput(array('with_empty' => false));
    $this->validatorSchema['score'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['profile_image'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['profile_image'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['total_views'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['total_views'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['total_plays'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['total_plays'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['favorited_count'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['favorited_count'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['favorite_badge_flag'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['favorite_badge_flag'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['reviewable'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['reviewable'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['wiki_lock'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['wiki_lock'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['spec_lock'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['spec_lock'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['procon_lock'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['procon_lock'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['module_specifications'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['module_specifications'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['module_features'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['module_features'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['module_procon'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['module_procon'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['module_products'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['module_products'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['limelight_type'] = new sfWidgetFormChoice(array('choices' => array('' => '', 'product' => 'product', 'technology' => 'technology', 'company' => 'company', 'source' => 'source', 'artist' => 'artist')));
    $this->validatorSchema['limelight_type'] = new sfValidatorChoice(array('required' => false, 'choices' => array('product' => 'product', 'technology' => 'technology', 'company' => 'company', 'source' => 'source', 'artist' => 'artist')));

    $this->widgetSchema   ['site'] = new sfWidgetFormChoice(array('choices' => array('' => '', 'tech' => 'tech', 'music' => 'music')));
    $this->validatorSchema['site'] = new sfValidatorChoice(array('required' => false, 'choices' => array('tech' => 'tech', 'music' => 'music')));

    $this->widgetSchema   ['company_name'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['company_name'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['company_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Company'), 'add_empty' => true));
    $this->validatorSchema['company_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Company'), 'column' => 'id'));

    $this->widgetSchema   ['is_stub'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['is_stub'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['name_slug'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['name_slug'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['categories_list'] = new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Category'));
    $this->validatorSchema['categories_list'] = new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Category', 'required' => false));

    $this->widgetSchema   ['newss_list'] = new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'News'));
    $this->validatorSchema['newss_list'] = new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'News', 'required' => false));

    $this->widgetSchema   ['songs_list'] = new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Song'));
    $this->validatorSchema['songs_list'] = new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Song', 'required' => false));

    $this->widgetSchema   ['wikis_list'] = new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Wiki'));
    $this->validatorSchema['wikis_list'] = new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Wiki', 'required' => false));

    $this->widgetSchema   ['followers_list'] = new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser'));
    $this->validatorSchema['followers_list'] = new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser', 'required' => false));

    $this->widgetSchema->setNameFormat('limelight_filters[%s]');
  }

  public function addCategoriesListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.CategoryLimelight CategoryLimelight')
      ->andWhereIn('CategoryLimelight.category_id', $values)
    ;
  }

  public function addNewssListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('LimelightNews.news_id', $values)
    ;
  }

  public function addSongsListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('LimelightSong.song_id', $values)
    ;
  }

  public function addWikisListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.LimelightWiki LimelightWiki')
      ->andWhereIn('LimelightWiki.wiki_group_id', $values)
    ;
  }

  public function addFollowersListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.FollowLimelightReference FollowLimelightReference')
      ->andWhereIn('FollowLimelightReference.user_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Limelight';
  }

  public function getFields()
  {
    return array_merge(parent::getFields(), array(
      'name' => 'Text',
      'score' => 'Number',
      'profile_image' => 'Text',
      'total_views' => 'Number',
      'total_plays' => 'Number',
      'favorited_count' => 'Number',
      'favorite_badge_flag' => 'Number',
      'reviewable' => 'Number',
      'wiki_lock' => 'Number',
      'spec_lock' => 'Number',
      'procon_lock' => 'Number',
      'module_specifications' => 'Text',
      'module_features' => 'Text',
      'module_procon' => 'Text',
      'module_products' => 'Text',
      'limelight_type' => 'Enum',
      'site' => 'Enum',
      'company_name' => 'Text',
      'company_id' => 'ForeignKey',
      'is_stub' => 'Number',
      'name_slug' => 'Text',
      'categories_list' => 'ManyKey',
      'newss_list' => 'ManyKey',
      'songs_list' => 'ManyKey',
      'wikis_list' => 'ManyKey',
      'followers_list' => 'ManyKey',
    ));
  }
}
