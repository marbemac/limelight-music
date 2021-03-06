<?php

/**
 * BaseLimelightViews
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $count
 * @property integer $limelight_id
 * @property integer $user_id
 * @property Limelight $Limelight
 * 
 * @method integer        getCount()        Returns the current record's "count" value
 * @method integer        getLimelightId()  Returns the current record's "limelight_id" value
 * @method integer        getUserId()       Returns the current record's "user_id" value
 * @method Limelight      getLimelight()    Returns the current record's "Limelight" value
 * @method LimelightViews setCount()        Sets the current record's "count" value
 * @method LimelightViews setLimelightId()  Sets the current record's "limelight_id" value
 * @method LimelightViews setUserId()       Sets the current record's "user_id" value
 * @method LimelightViews setLimelight()    Sets the current record's "Limelight" value
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseLimelightViews extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('limelight_views');
        $this->hasColumn('count', 'integer', 11, array(
             'type' => 'integer',
             'default' => 1,
             'length' => '11',
             ));
        $this->hasColumn('limelight_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Limelight', array(
             'local' => 'limelight_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}