<?php

/**
 * BaseCategory
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property enum $status
 * @property integer $num_limelights
 * @property integer $num_news
 * @property string $amazon_category
 * @property enum $site
 * @property integer $parent_id
 * @property Category $Parent
 * @property Doctrine_Collection $Children
 * @property Doctrine_Collection $CategoryLimelight
 * @property Doctrine_Collection $Limelight
 * @property Doctrine_Collection $Specifications
 * @property Doctrine_Collection $ScoreTypes
 * 
 * @method integer             getId()                Returns the current record's "id" value
 * @method string              getName()              Returns the current record's "name" value
 * @method enum                getStatus()            Returns the current record's "status" value
 * @method integer             getNumLimelights()     Returns the current record's "num_limelights" value
 * @method integer             getNumNews()           Returns the current record's "num_news" value
 * @method string              getAmazonCategory()    Returns the current record's "amazon_category" value
 * @method enum                getSite()              Returns the current record's "site" value
 * @method integer             getParentId()          Returns the current record's "parent_id" value
 * @method Category            getParent()            Returns the current record's "Parent" value
 * @method Doctrine_Collection getChildren()          Returns the current record's "Children" collection
 * @method Doctrine_Collection getCategoryLimelight() Returns the current record's "CategoryLimelight" collection
 * @method Doctrine_Collection getLimelight()         Returns the current record's "Limelight" collection
 * @method Doctrine_Collection getSpecifications()    Returns the current record's "Specifications" collection
 * @method Doctrine_Collection getScoreTypes()        Returns the current record's "ScoreTypes" collection
 * @method Category            setId()                Sets the current record's "id" value
 * @method Category            setName()              Sets the current record's "name" value
 * @method Category            setStatus()            Sets the current record's "status" value
 * @method Category            setNumLimelights()     Sets the current record's "num_limelights" value
 * @method Category            setNumNews()           Sets the current record's "num_news" value
 * @method Category            setAmazonCategory()    Sets the current record's "amazon_category" value
 * @method Category            setSite()              Sets the current record's "site" value
 * @method Category            setParentId()          Sets the current record's "parent_id" value
 * @method Category            setParent()            Sets the current record's "Parent" value
 * @method Category            setChildren()          Sets the current record's "Children" collection
 * @method Category            setCategoryLimelight() Sets the current record's "CategoryLimelight" collection
 * @method Category            setLimelight()         Sets the current record's "Limelight" collection
 * @method Category            setSpecifications()    Sets the current record's "Specifications" collection
 * @method Category            setScoreTypes()        Sets the current record's "ScoreTypes" collection
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCategory extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('category');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('status', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'Active',
              1 => 'Pending',
              2 => 'Struck',
              3 => 'Flagged',
              4 => 'Disabled',
             ),
             'notnull' => true,
             'default' => 'Pending',
             ));
        $this->hasColumn('num_limelights', 'integer', 4, array(
             'type' => 'integer',
             'default' => 0,
             'length' => 4,
             ));
        $this->hasColumn('num_news', 'integer', 4, array(
             'type' => 'integer',
             'default' => 0,
             'length' => 4,
             ));
        $this->hasColumn('amazon_category', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('site', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'tech',
              1 => 'music',
             ),
             'default' => 'tech',
             ));
        $this->hasColumn('parent_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));


        $this->index('index', array(
             'fields' => 
             array(
              0 => 'parent_id',
             ),
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Category as Parent', array(
             'local' => 'parent_id',
             'foreign' => 'id'));

        $this->hasMany('Category as Children', array(
             'local' => 'id',
             'foreign' => 'parent_id'));

        $this->hasMany('CategoryLimelight', array(
             'local' => 'id',
             'foreign' => 'category_id'));

        $this->hasMany('Limelight', array(
             'refClass' => 'CategoryLimelight',
             'local' => 'category_id',
             'foreign' => 'limelight_id'));

        $this->hasMany('CategorySpecification as Specifications', array(
             'local' => 'id',
             'foreign' => 'category_id'));

        $this->hasMany('CategoryScoreType as ScoreTypes', array(
             'local' => 'id',
             'foreign' => 'category_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $sluggable0 = new Doctrine_Template_Sluggable(array(
             'fields' => 
             array(
              0 => 'name',
             ),
             'name' => 'name_slug',
             ));
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
        $this->actAs($sluggable0);
    }
}