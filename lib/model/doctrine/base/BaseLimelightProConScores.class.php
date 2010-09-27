<?php

/**
 * BaseLimelightProConScores
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $count
 * @property date $date
 * @property integer $limelightprocon_id
 * @property integer $user_id
 * @property integer $target_user_id
 * @property LimelightProCon $LimelightProCon
 * 
 * @method integer               getCount()              Returns the current record's "count" value
 * @method date                  getDate()               Returns the current record's "date" value
 * @method integer               getLimelightproconId()  Returns the current record's "limelightprocon_id" value
 * @method integer               getUserId()             Returns the current record's "user_id" value
 * @method integer               getTargetUserId()       Returns the current record's "target_user_id" value
 * @method LimelightProCon       getLimelightProCon()    Returns the current record's "LimelightProCon" value
 * @method LimelightProConScores setCount()              Sets the current record's "count" value
 * @method LimelightProConScores setDate()               Sets the current record's "date" value
 * @method LimelightProConScores setLimelightproconId()  Sets the current record's "limelightprocon_id" value
 * @method LimelightProConScores setUserId()             Sets the current record's "user_id" value
 * @method LimelightProConScores setTargetUserId()       Sets the current record's "target_user_id" value
 * @method LimelightProConScores setLimelightProCon()    Sets the current record's "LimelightProCon" value
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseLimelightProConScores extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('limelight_pro_con_scores');
        $this->hasColumn('count', 'integer', 3, array(
             'type' => 'integer',
             'default' => 1,
             'length' => '3',
             ));
        $this->hasColumn('date', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('limelightprocon_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('target_user_id', 'integer', null, array(
             'type' => 'integer',
             ));


        $this->index('index', array(
             'fields' => 
             array(
              0 => 'user_id',
             ),
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('LimelightProCon', array(
             'local' => 'limelightprocon_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}