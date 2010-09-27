<?php

/**
 * BaseLimelightSpec
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property string $name_slug
 * @property string $content
 * @property string $source_name
 * @property string $source_url
 * @property integer $limelight_id
 * @property sfGuardUser $User
 * @property Limelight $Limelight
 * @property Doctrine_Collection $Flags
 * 
 * @method string              getName()         Returns the current record's "name" value
 * @method string              getNameSlug()     Returns the current record's "name_slug" value
 * @method string              getContent()      Returns the current record's "content" value
 * @method string              getSourceName()   Returns the current record's "source_name" value
 * @method string              getSourceUrl()    Returns the current record's "source_url" value
 * @method integer             getLimelightId()  Returns the current record's "limelight_id" value
 * @method sfGuardUser         getUser()         Returns the current record's "User" value
 * @method Limelight           getLimelight()    Returns the current record's "Limelight" value
 * @method Doctrine_Collection getFlags()        Returns the current record's "Flags" collection
 * @method LimelightSpec       setName()         Sets the current record's "name" value
 * @method LimelightSpec       setNameSlug()     Sets the current record's "name_slug" value
 * @method LimelightSpec       setContent()      Sets the current record's "content" value
 * @method LimelightSpec       setSourceName()   Sets the current record's "source_name" value
 * @method LimelightSpec       setSourceUrl()    Sets the current record's "source_url" value
 * @method LimelightSpec       setLimelightId()  Sets the current record's "limelight_id" value
 * @method LimelightSpec       setUser()         Sets the current record's "User" value
 * @method LimelightSpec       setLimelight()    Sets the current record's "Limelight" value
 * @method LimelightSpec       setFlags()        Sets the current record's "Flags" collection
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseLimelightSpec extends Item
{
    public function setTableDefinition()
    {
        parent::setTableDefinition();
        $this->setTableName('limelight_spec');
        $this->hasColumn('name', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('name_slug', 'string', 50, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 50,
             ));
        $this->hasColumn('content', 'string', 150, array(
             'type' => 'string',
             'length' => 150,
             ));
        $this->hasColumn('source_name', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('source_url', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('limelight_id', 'integer', null, array(
             'type' => 'integer',
             ));


        $this->index('limelightIndex', array(
             'fields' => 
             array(
              0 => 'limelight_id',
             ),
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('sfGuardUser as User', array(
             'local' => 'user_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Limelight', array(
             'local' => 'limelight_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('LimelightSpecFlag as Flags', array(
             'local' => 'id',
             'foreign' => 'item_id'));

        $sluggable0 = new Doctrine_Template_Sluggable(array(
             'fields' => 
             array(
              0 => 'name',
             ),
             'name' => 'name_slug',
             ));
        $this->actAs($sluggable0);
    }
}