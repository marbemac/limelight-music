<?php

/**
 * BaseLimelightReviewUser
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $user_id
 * @property integer $item_id
 * @property string $title
 * @property string $content
 * @property integer $score
 * @property integer $review_score
 * @property integer $edited
 * @property sfGuardUser $User
 * @property Limelight $Item
 * @property Doctrine_Collection $Comments
 * @property Doctrine_Collection $UserAction
 * @property Doctrine_Collection $Parts
 * @property Doctrine_Collection $Scores
 * @property Doctrine_Collection $Flags
 * 
 * @method integer             getUserId()       Returns the current record's "user_id" value
 * @method integer             getItemId()       Returns the current record's "item_id" value
 * @method string              getTitle()        Returns the current record's "title" value
 * @method string              getContent()      Returns the current record's "content" value
 * @method integer             getScore()        Returns the current record's "score" value
 * @method integer             getReviewScore()  Returns the current record's "review_score" value
 * @method integer             getEdited()       Returns the current record's "edited" value
 * @method sfGuardUser         getUser()         Returns the current record's "User" value
 * @method Limelight           getItem()         Returns the current record's "Item" value
 * @method Doctrine_Collection getComments()     Returns the current record's "Comments" collection
 * @method Doctrine_Collection getUserAction()   Returns the current record's "UserAction" collection
 * @method Doctrine_Collection getParts()        Returns the current record's "Parts" collection
 * @method Doctrine_Collection getScores()       Returns the current record's "Scores" collection
 * @method Doctrine_Collection getFlags()        Returns the current record's "Flags" collection
 * @method LimelightReviewUser setUserId()       Sets the current record's "user_id" value
 * @method LimelightReviewUser setItemId()       Sets the current record's "item_id" value
 * @method LimelightReviewUser setTitle()        Sets the current record's "title" value
 * @method LimelightReviewUser setContent()      Sets the current record's "content" value
 * @method LimelightReviewUser setScore()        Sets the current record's "score" value
 * @method LimelightReviewUser setReviewScore()  Sets the current record's "review_score" value
 * @method LimelightReviewUser setEdited()       Sets the current record's "edited" value
 * @method LimelightReviewUser setUser()         Sets the current record's "User" value
 * @method LimelightReviewUser setItem()         Sets the current record's "Item" value
 * @method LimelightReviewUser setComments()     Sets the current record's "Comments" collection
 * @method LimelightReviewUser setUserAction()   Sets the current record's "UserAction" collection
 * @method LimelightReviewUser setParts()        Sets the current record's "Parts" collection
 * @method LimelightReviewUser setScores()       Sets the current record's "Scores" collection
 * @method LimelightReviewUser setFlags()        Sets the current record's "Flags" collection
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseLimelightReviewUser extends Item
{
    public function setTableDefinition()
    {
        parent::setTableDefinition();
        $this->setTableName('limelight_review_user');
        $this->hasColumn('user_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('item_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('title', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('content', 'string', 1000, array(
             'type' => 'string',
             'length' => 1000,
             ));
        $this->hasColumn('score', 'integer', 4, array(
             'type' => 'integer',
             'default' => 0,
             'length' => 4,
             ));
        $this->hasColumn('review_score', 'integer', 3, array(
             'type' => 'integer',
             'default' => 0,
             'length' => 3,
             ));
        $this->hasColumn('edited', 'integer', 2, array(
             'type' => 'integer',
             'default' => 0,
             'notnull' => true,
             'length' => 2,
             ));


        $this->index('index', array(
             'fields' => 
             array(
              0 => 'item_id',
              1 => 'user_id',
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

        $this->hasOne('Limelight as Item', array(
             'local' => 'item_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('Comment as Comments', array(
             'local' => 'id',
             'foreign' => 'LimelightReviewUser_id'));

        $this->hasMany('UserAction', array(
             'local' => 'id',
             'foreign' => 'LimelightReviewUser_id'));

        $this->hasMany('LimelightReviewScorePart as Parts', array(
             'local' => 'id',
             'foreign' => 'review_id'));

        $this->hasMany('LimelightReviewUserScore as Scores', array(
             'local' => 'id',
             'foreign' => 'item_id'));

        $this->hasMany('LimelightReviewUserFlag as Flags', array(
             'local' => 'id',
             'foreign' => 'item_id'));
    }
}