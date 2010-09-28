<?php

/**
 * BaseItemTag
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $score
 * @property integer $tag_id
 * @property integer $item_id
 * @property enum $type
 * @property sfGuardUser $User
 * @property Tag $Tag
 * @property News $Item
 * @property Doctrine_Collection $Scores
 * @property Doctrine_Collection $Flags
 * 
 * @method integer             getScore()   Returns the current record's "score" value
 * @method integer             getTagId()   Returns the current record's "tag_id" value
 * @method integer             getItemId()  Returns the current record's "item_id" value
 * @method enum                getType()    Returns the current record's "type" value
 * @method sfGuardUser         getUser()    Returns the current record's "User" value
 * @method Tag                 getTag()     Returns the current record's "Tag" value
 * @method News                getItem()    Returns the current record's "Item" value
 * @method Doctrine_Collection getScores()  Returns the current record's "Scores" collection
 * @method Doctrine_Collection getFlags()   Returns the current record's "Flags" collection
 * @method ItemTag             setScore()   Sets the current record's "score" value
 * @method ItemTag             setTagId()   Sets the current record's "tag_id" value
 * @method ItemTag             setItemId()  Sets the current record's "item_id" value
 * @method ItemTag             setType()    Sets the current record's "type" value
 * @method ItemTag             setUser()    Sets the current record's "User" value
 * @method ItemTag             setTag()     Sets the current record's "Tag" value
 * @method ItemTag             setItem()    Sets the current record's "Item" value
 * @method ItemTag             setScores()  Sets the current record's "Scores" collection
 * @method ItemTag             setFlags()   Sets the current record's "Flags" collection
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseItemTag extends Item
{
    public function setTableDefinition()
    {
        parent::setTableDefinition();
        $this->setTableName('item_tag');
        $this->hasColumn('score', 'integer', 4, array(
             'type' => 'integer',
             'default' => 0,
             'length' => 4,
             ));
        $this->hasColumn('tag_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('item_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('type', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'news',
              1 => 'song',
              2 => 'limelight',
             ),
             'default' => 'Song',
             ));


        $this->index('itemIndex', array(
             'fields' => 
             array(
              0 => 'item_id',
             ),
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('sfGuardUser as User', array(
             'local' => 'user_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Tag', array(
             'local' => 'tag_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('News as Item', array(
             'local' => 'item_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('ItemTagScore as Scores', array(
             'local' => 'id',
             'foreign' => 'item_id'));

        $this->hasMany('ItemTagFlag as Flags', array(
             'local' => 'id',
             'foreign' => 'item_id'));
    }
}