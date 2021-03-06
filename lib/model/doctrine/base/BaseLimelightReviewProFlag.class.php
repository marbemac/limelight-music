<?php

/**
 * BaseLimelightReviewProFlag
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property LimelightReviewPro $Item
 * 
 * @method LimelightReviewPro     getItem() Returns the current record's "Item" value
 * @method LimelightReviewProFlag setItem() Sets the current record's "Item" value
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseLimelightReviewProFlag extends Flag
{
    public function setTableDefinition()
    {
        parent::setTableDefinition();
        $this->setTableName('limelight_review_pro_flag');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('LimelightReviewPro as Item', array(
             'local' => 'item_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}