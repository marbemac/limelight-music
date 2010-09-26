<?php

/**
 * Wiki filter form base class.
 *
 * @package    limelight
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseWikiFormFilter extends ItemFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['topics'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['topics'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['content'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['content'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['note'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['note'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['version'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['version'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['score'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['score'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['is_active'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['is_active'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['edit_type'] = new sfWidgetFormChoice(array('choices' => array('' => '', 'minor' => 'minor', 'major' => 'major')));
    $this->validatorSchema['edit_type'] = new sfValidatorChoice(array('required' => false, 'choices' => array('minor' => 'minor', 'major' => 'major')));

    $this->widgetSchema   ['edit_lock'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['edit_lock'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['edit_lock_start'] = new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate()));
    $this->validatorSchema['edit_lock_start'] = new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59'))));

    $this->widgetSchema   ['edit_lock_time'] = new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate()));
    $this->validatorSchema['edit_lock_time'] = new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59'))));

    $this->widgetSchema   ['edit_lock_user_id'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['edit_lock_user_id'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['lock_code'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['lock_code'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['group_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LimelightWikis'), 'add_empty' => true));
    $this->validatorSchema['group_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('LimelightWikis'), 'column' => 'id'));

    $this->widgetSchema   ['limelights_list'] = new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Limelight'));
    $this->validatorSchema['limelights_list'] = new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Limelight', 'required' => false));

    $this->widgetSchema->setNameFormat('wiki_filters[%s]');
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
      ->leftJoin($query->getRootAlias().'.LimelightWiki LimelightWiki')
      ->andWhereIn('LimelightWiki.limelight_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Wiki';
  }

  public function getFields()
  {
    return array_merge(parent::getFields(), array(
      'topics' => 'Text',
      'content' => 'Text',
      'note' => 'Text',
      'version' => 'Number',
      'score' => 'Number',
      'is_active' => 'Text',
      'edit_type' => 'Enum',
      'edit_lock' => 'Text',
      'edit_lock_start' => 'Date',
      'edit_lock_time' => 'Date',
      'edit_lock_user_id' => 'Number',
      'lock_code' => 'Text',
      'group_id' => 'ForeignKey',
      'limelights_list' => 'ManyKey',
    ));
  }
}
