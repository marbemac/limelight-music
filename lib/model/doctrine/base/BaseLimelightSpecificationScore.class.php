<?php

/**
 * BaseLimelightSpecificationScore
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property LimelightSpecification $Item
 * 
 * @method LimelightSpecification      getItem() Returns the current record's "Item" value
 * @method LimelightSpecificationScore setItem() Sets the current record's "Item" value
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseLimelightSpecificationScore extends Score
{
    public function setTableDefinition()
    {
        parent::setTableDefinition();
        $this->setTableName('limelight_specification_score');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('LimelightSpecification as Item', array(
             'local' => 'item_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}