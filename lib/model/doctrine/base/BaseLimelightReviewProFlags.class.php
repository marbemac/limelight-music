<?php

/**
 * BaseLimelightReviewProFlags
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $review_id
 * @property enum $flag_type
 * @property integer $user_id
 * @property sfGuardUser $User
 * @property LimelightReviewPro $LimelightReviewPro
 * 
 * @method integer                 getReviewId()           Returns the current record's "review_id" value
 * @method enum                    getFlagType()           Returns the current record's "flag_type" value
 * @method integer                 getUserId()             Returns the current record's "user_id" value
 * @method sfGuardUser             getUser()               Returns the current record's "User" value
 * @method LimelightReviewPro      getLimelightReviewPro() Returns the current record's "LimelightReviewPro" value
 * @method LimelightReviewProFlags setReviewId()           Sets the current record's "review_id" value
 * @method LimelightReviewProFlags setFlagType()           Sets the current record's "flag_type" value
 * @method LimelightReviewProFlags setUserId()             Sets the current record's "user_id" value
 * @method LimelightReviewProFlags setUser()               Sets the current record's "User" value
 * @method LimelightReviewProFlags setLimelightReviewPro() Sets the current record's "LimelightReviewPro" value
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseLimelightReviewProFlags extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('limelight_review_pro_flags');
        $this->hasColumn('review_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('flag_type', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'Duplicate',
              1 => 'Wrong Limelight',
              2 => 'Spam',
              3 => 'Broken Link',
              4 => 'Other',
             ),
             ));
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('sfGuardUser as User', array(
             'local' => 'user_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('LimelightReviewPro', array(
             'local' => 'review_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}