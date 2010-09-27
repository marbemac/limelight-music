<?php

/**
 * BaseBadge
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $type
 * @property string $image_name
 * @property enum $site
 * @property string $status
 * @property Doctrine_Collection $BadgeLevels
 * @property Doctrine_Collection $UserBadges
 * 
 * @method integer             getId()          Returns the current record's "id" value
 * @method string              getName()        Returns the current record's "name" value
 * @method string              getDescription() Returns the current record's "description" value
 * @method string              getType()        Returns the current record's "type" value
 * @method string              getImageName()   Returns the current record's "image_name" value
 * @method enum                getSite()        Returns the current record's "site" value
 * @method string              getStatus()      Returns the current record's "status" value
 * @method Doctrine_Collection getBadgeLevels() Returns the current record's "BadgeLevels" collection
 * @method Doctrine_Collection getUserBadges()  Returns the current record's "UserBadges" collection
 * @method Badge               setId()          Sets the current record's "id" value
 * @method Badge               setName()        Sets the current record's "name" value
 * @method Badge               setDescription() Sets the current record's "description" value
 * @method Badge               setType()        Sets the current record's "type" value
 * @method Badge               setImageName()   Sets the current record's "image_name" value
 * @method Badge               setSite()        Sets the current record's "site" value
 * @method Badge               setStatus()      Sets the current record's "status" value
 * @method Badge               setBadgeLevels() Sets the current record's "BadgeLevels" collection
 * @method Badge               setUserBadges()  Sets the current record's "UserBadges" collection
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseBadge extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('badge');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('description', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('type', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('image_name', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
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
        $this->hasColumn('status', 'string', 50, array(
             'type' => 'string',
             'default' => 'Active',
             'length' => 50,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('BadgeLevel as BadgeLevels', array(
             'local' => 'id',
             'foreign' => 'badge_id'));

        $this->hasMany('UserBadge as UserBadges', array(
             'local' => 'id',
             'foreign' => 'badge_id'));

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