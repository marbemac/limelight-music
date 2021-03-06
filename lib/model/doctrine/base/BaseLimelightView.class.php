<?php

/**
 * BaseLimelightView
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $item_id
 * @property Limelight $Item
 * 
 * @method integer       getItemId()  Returns the current record's "item_id" value
 * @method Limelight     getItem()    Returns the current record's "Item" value
 * @method LimelightView setItemId()  Sets the current record's "item_id" value
 * @method LimelightView setItem()    Sets the current record's "Item" value
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseLimelightView extends View
{
    public function setTableDefinition()
    {
        parent::setTableDefinition();
        $this->setTableName('limelight_view');
        $this->hasColumn('item_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));


        $this->index('limelightIndex', array(
             'fields' => 
             array(
              0 => 'item_id',
             ),
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Limelight as Item', array(
             'local' => 'item_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}