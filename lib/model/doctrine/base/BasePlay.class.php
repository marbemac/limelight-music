<?php

/**
 * BasePlay
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $count
 * @property integer $user_id
 * @property sfGuardUser $User
 * 
 * @method integer     getId()      Returns the current record's "id" value
 * @method integer     getCount()   Returns the current record's "count" value
 * @method integer     getUserId()  Returns the current record's "user_id" value
 * @method sfGuardUser getUser()    Returns the current record's "User" value
 * @method Play        setId()      Sets the current record's "id" value
 * @method Play        setCount()   Sets the current record's "count" value
 * @method Play        setUserId()  Sets the current record's "user_id" value
 * @method Play        setUser()    Sets the current record's "User" value
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePlay extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('play');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('count', 'integer', 4, array(
             'type' => 'integer',
             'default' => 1,
             'length' => 4,
             ));
        $this->hasColumn('user_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));


        $this->index('userIndex', array(
             'fields' => 
             array(
              0 => 'user_id',
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