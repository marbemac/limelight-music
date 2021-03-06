<?php

/**
 * BaseFollowUserReference
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $user1_id
 * @property integer $user2_id
 * 
 * @method integer             getUser1Id()  Returns the current record's "user1_id" value
 * @method integer             getUser2Id()  Returns the current record's "user2_id" value
 * @method FollowUserReference setUser1Id()  Sets the current record's "user1_id" value
 * @method FollowUserReference setUser2Id()  Sets the current record's "user2_id" value
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseFollowUserReference extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('follow_user_reference');
        $this->hasColumn('user1_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('user2_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));

        $this->option('symfony', array(
             'form' => false,
             'filter' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}