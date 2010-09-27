<?php

/**
 * BaseCommentScore
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property Comment $Item
 * 
 * @method Comment      getItem() Returns the current record's "Item" value
 * @method CommentScore setItem() Sets the current record's "Item" value
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCommentScore extends Score
{
    public function setTableDefinition()
    {
        parent::setTableDefinition();
        $this->setTableName('comment_score');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Comment as Item', array(
             'local' => 'item_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}