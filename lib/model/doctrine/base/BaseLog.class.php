<?php

/**
 * BaseLog
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $type
 * @property string $message
 * @property integer $user_id
 * @property string $ip_address
 * 
 * @method integer getId()         Returns the current record's "id" value
 * @method string  getType()       Returns the current record's "type" value
 * @method string  getMessage()    Returns the current record's "message" value
 * @method integer getUserId()     Returns the current record's "user_id" value
 * @method string  getIpAddress()  Returns the current record's "ip_address" value
 * @method Log     setId()         Sets the current record's "id" value
 * @method Log     setType()       Sets the current record's "type" value
 * @method Log     setMessage()    Sets the current record's "message" value
 * @method Log     setUserId()     Sets the current record's "user_id" value
 * @method Log     setIpAddress()  Sets the current record's "ip_address" value
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseLog extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('log');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('type', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('message', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('user_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('ip_address', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));


        $this->index('userIndex', array(
             'fields' => 
             array(
              0 => 'user_id',
             ),
             ));
        $this->index('typeIndex', array(
             'fields' => 
             array(
              0 => 'type',
             ),
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}