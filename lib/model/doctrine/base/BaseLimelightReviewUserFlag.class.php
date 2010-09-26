<?php

/**
 * BaseLimelightReviewUserFlag
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property LimelightReviewUser $Item
 * 
 * @method LimelightReviewUser     getItem() Returns the current record's "Item" value
 * @method LimelightReviewUserFlag setItem() Sets the current record's "Item" value
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseLimelightReviewUserFlag extends Flag
{
    public function setTableDefinition()
    {
        parent::setTableDefinition();
        $this->setTableName('limelight_review_user_flag');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('LimelightReviewUser as Item', array(
             'local' => 'item_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}