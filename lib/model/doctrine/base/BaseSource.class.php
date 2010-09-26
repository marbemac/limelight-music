<?php

/**
 * BaseSource
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $source_name
 * @property enum $status
 * @property string $description
 * @property string $url
 * @property integer $score
 * @property integer $user_id
 * @property sfGuardUser $User
 * @property Doctrine_Collection $Specifications
 * @property Doctrine_Collection $NewsLinks
 * @property Doctrine_Collection $ProReviews
 * @property Doctrine_Collection $Views
 * 
 * @method integer             getId()             Returns the current record's "id" value
 * @method string              getSourceName()     Returns the current record's "source_name" value
 * @method enum                getStatus()         Returns the current record's "status" value
 * @method string              getDescription()    Returns the current record's "description" value
 * @method string              getUrl()            Returns the current record's "url" value
 * @method integer             getScore()          Returns the current record's "score" value
 * @method integer             getUserId()         Returns the current record's "user_id" value
 * @method sfGuardUser         getUser()           Returns the current record's "User" value
 * @method Doctrine_Collection getSpecifications() Returns the current record's "Specifications" collection
 * @method Doctrine_Collection getNewsLinks()      Returns the current record's "NewsLinks" collection
 * @method Doctrine_Collection getProReviews()     Returns the current record's "ProReviews" collection
 * @method Doctrine_Collection getViews()          Returns the current record's "Views" collection
 * @method Source              setId()             Sets the current record's "id" value
 * @method Source              setSourceName()     Sets the current record's "source_name" value
 * @method Source              setStatus()         Sets the current record's "status" value
 * @method Source              setDescription()    Sets the current record's "description" value
 * @method Source              setUrl()            Sets the current record's "url" value
 * @method Source              setScore()          Sets the current record's "score" value
 * @method Source              setUserId()         Sets the current record's "user_id" value
 * @method Source              setUser()           Sets the current record's "User" value
 * @method Source              setSpecifications() Sets the current record's "Specifications" collection
 * @method Source              setNewsLinks()      Sets the current record's "NewsLinks" collection
 * @method Source              setProReviews()     Sets the current record's "ProReviews" collection
 * @method Source              setViews()          Sets the current record's "Views" collection
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseSource extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('source');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('source_name', 'string', 255, array(
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
              2 => 'Flagged',
              3 => 'Struck',
              4 => 'Disabled',
             ),
             'notnull' => true,
             'default' => 'Active',
             ));
        $this->hasColumn('description', 'string', 400, array(
             'type' => 'string',
             'length' => 400,
             ));
        $this->hasColumn('url', 'string', 200, array(
             'type' => 'string',
             'length' => 200,
             ));
        $this->hasColumn('score', 'integer', 4, array(
             'type' => 'integer',
             'default' => 0,
             'length' => 4,
             ));
        $this->hasColumn('user_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));


        $this->index('name', array(
             'fields' => 
             array(
              0 => 'source_name',
             ),
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('sfGuardUser as User', array(
             'local' => 'user_id',
             'foreign' => 'id'));

        $this->hasMany('LimelightSpecification as Specifications', array(
             'local' => 'id',
             'foreign' => 'source_id'));

        $this->hasMany('NewsLink as NewsLinks', array(
             'local' => 'id',
             'foreign' => 'source_id'));

        $this->hasMany('LimelightReviewPro as ProReviews', array(
             'local' => 'id',
             'foreign' => 'source_id'));

        $this->hasMany('SourceView as Views', array(
             'local' => 'id',
             'foreign' => 'item_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $sluggable0 = new Doctrine_Template_Sluggable(array(
             'fields' => 
             array(
              0 => 'source_name',
             ),
             'name' => 'name_slug',
             ));
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
        $this->actAs($sluggable0);
    }
}