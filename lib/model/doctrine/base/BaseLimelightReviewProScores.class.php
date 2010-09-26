<?php

/**
 * BaseLimelightReviewProScores
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $count
 * @property integer $review_id
 * @property integer $user_id
 * @property integer $target_user_id
 * @property LimelightReviewPro $LimelightReviewPro
 * @property sfGuardUser $Rater
 * @property sfGuardUser $TargetUser
 * 
 * @method integer                  getCount()              Returns the current record's "count" value
 * @method integer                  getReviewId()           Returns the current record's "review_id" value
 * @method integer                  getUserId()             Returns the current record's "user_id" value
 * @method integer                  getTargetUserId()       Returns the current record's "target_user_id" value
 * @method LimelightReviewPro       getLimelightReviewPro() Returns the current record's "LimelightReviewPro" value
 * @method sfGuardUser              getRater()              Returns the current record's "Rater" value
 * @method sfGuardUser              getTargetUser()         Returns the current record's "TargetUser" value
 * @method LimelightReviewProScores setCount()              Sets the current record's "count" value
 * @method LimelightReviewProScores setReviewId()           Sets the current record's "review_id" value
 * @method LimelightReviewProScores setUserId()             Sets the current record's "user_id" value
 * @method LimelightReviewProScores setTargetUserId()       Sets the current record's "target_user_id" value
 * @method LimelightReviewProScores setLimelightReviewPro() Sets the current record's "LimelightReviewPro" value
 * @method LimelightReviewProScores setRater()              Sets the current record's "Rater" value
 * @method LimelightReviewProScores setTargetUser()         Sets the current record's "TargetUser" value
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseLimelightReviewProScores extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('limelight_review_pro_scores');
        $this->hasColumn('count', 'integer', 3, array(
             'type' => 'integer',
             'default' => 1,
             'length' => '3',
             ));
        $this->hasColumn('review_id', 'integer', null, array(
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
        $this->hasOne('LimelightReviewPro', array(
             'local' => 'review_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('sfGuardUser as Rater', array(
             'local' => 'user_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('sfGuardUser as TargetUser', array(
             'local' => 'target_user_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}