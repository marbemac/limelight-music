<?php

/**
 * BaseLimelightSpecFlags
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $limelight_spec_id
 * @property enum $flag_type
 * @property integer $user_id
 * @property sfGuardUser $User
 * @property LimelightSpec $LimelightSpec
 * 
 * @method integer            getLimelightSpecId()   Returns the current record's "limelight_spec_id" value
 * @method enum               getFlagType()          Returns the current record's "flag_type" value
 * @method integer            getUserId()            Returns the current record's "user_id" value
 * @method sfGuardUser        getUser()              Returns the current record's "User" value
 * @method LimelightSpec      getLimelightSpec()     Returns the current record's "LimelightSpec" value
 * @method LimelightSpecFlags setLimelightSpecId()   Sets the current record's "limelight_spec_id" value
 * @method LimelightSpecFlags setFlagType()          Sets the current record's "flag_type" value
 * @method LimelightSpecFlags setUserId()            Sets the current record's "user_id" value
 * @method LimelightSpecFlags setUser()              Sets the current record's "User" value
 * @method LimelightSpecFlags setLimelightSpec()     Sets the current record's "LimelightSpec" value
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseLimelightSpecFlags extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('limelight_spec_flags');
        $this->hasColumn('limelight_spec_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('flag_type', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'Duplicate',
              1 => 'Inappropriate',
              2 => 'Incorrect',
              3 => 'Spam',
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

        $this->hasOne('LimelightSpec', array(
             'local' => 'limelight_spec_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}