<?php

/**
 * BaseFlag
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property enum $type
 * @property integer $user_id
 * @property integer $item_id
 * @property sfGuardUser $User
 * 
 * @method integer     getId()      Returns the current record's "id" value
 * @method enum        getType()    Returns the current record's "type" value
 * @method integer     getUserId()  Returns the current record's "user_id" value
 * @method integer     getItemId()  Returns the current record's "item_id" value
 * @method sfGuardUser getUser()    Returns the current record's "User" value
 * @method Flag        setId()      Sets the current record's "id" value
 * @method Flag        setType()    Sets the current record's "type" value
 * @method Flag        setUserId()  Sets the current record's "user_id" value
 * @method Flag        setItemId()  Sets the current record's "item_id" value
 * @method Flag        setUser()    Sets the current record's "User" value
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseFlag extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('flag');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('type', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'Duplicate',
              1 => 'Wrong Limelight',
              2 => 'Spam',
              3 => 'Broken Link',
              4 => 'Innapropriate',
              5 => 'Other',
             ),
             ));
        $this->hasColumn('user_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('item_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));


        $this->index('userIndex', array(
             'fields' => 
             array(
              0 => 'user_id',
             ),
             ));
        $this->index('itemIndex', array(
             'fields' => 
             array(
              0 => 'item_id',
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

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}