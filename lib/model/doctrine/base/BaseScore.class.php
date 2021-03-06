<?php

/**
 * BaseScore
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $amount
 * @property enum $status
 * @property integer $user_id
 * @property integer $target_user_id
 * @property integer $item_id
 * @property sfGuardUser $Rater
 * @property sfGuardUser $TargetUser
 * 
 * @method integer     getId()             Returns the current record's "id" value
 * @method integer     getAmount()         Returns the current record's "amount" value
 * @method enum        getStatus()         Returns the current record's "status" value
 * @method integer     getUserId()         Returns the current record's "user_id" value
 * @method integer     getTargetUserId()   Returns the current record's "target_user_id" value
 * @method integer     getItemId()         Returns the current record's "item_id" value
 * @method sfGuardUser getRater()          Returns the current record's "Rater" value
 * @method sfGuardUser getTargetUser()     Returns the current record's "TargetUser" value
 * @method Score       setId()             Sets the current record's "id" value
 * @method Score       setAmount()         Sets the current record's "amount" value
 * @method Score       setStatus()         Sets the current record's "status" value
 * @method Score       setUserId()         Sets the current record's "user_id" value
 * @method Score       setTargetUserId()   Sets the current record's "target_user_id" value
 * @method Score       setItemId()         Sets the current record's "item_id" value
 * @method Score       setRater()          Sets the current record's "Rater" value
 * @method Score       setTargetUser()     Sets the current record's "TargetUser" value
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseScore extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('score');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('amount', 'integer', 3, array(
             'type' => 'integer',
             'default' => 1,
             'length' => 3,
             ));
        $this->hasColumn('status', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'Flagged',
              1 => 'Struck',
              2 => 'Disabled',
              3 => 'Active',
             ),
             'default' => 'Active',
             ));
        $this->hasColumn('user_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('target_user_id', 'integer', 4, array(
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
        $this->hasOne('sfGuardUser as Rater', array(
             'local' => 'user_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('sfGuardUser as TargetUser', array(
             'local' => 'target_user_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}