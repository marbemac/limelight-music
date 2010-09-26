<?php

/**
 * BaseNewsTagFlag
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property NewsTag $Item
 * 
 * @method NewsTag     getItem() Returns the current record's "Item" value
 * @method NewsTagFlag setItem() Sets the current record's "Item" value
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseNewsTagFlag extends Flag
{
    public function setTableDefinition()
    {
        parent::setTableDefinition();
        $this->setTableName('news_tag_flag');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('NewsTag as Item', array(
             'local' => 'item_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}