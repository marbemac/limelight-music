<?php

/**
 * BaseWiki
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $topics
 * @property string $content
 * @property string $note
 * @property integer $version
 * @property integer $score
 * @property bool $is_active
 * @property enum $edit_type
 * @property bool $edit_lock
 * @property datetime $edit_lock_start
 * @property datetime $edit_lock_time
 * @property integer $edit_lock_user_id
 * @property bool $lock_code
 * @property integer $group_id
 * @property sfGuardUser $User
 * @property Doctrine_Collection $Limelights
 * @property Doctrine_Collection $LimelightWikis
 * @property Doctrine_Collection $Comments
 * @property Doctrine_Collection $UserAction
 * @property Doctrine_Collection $Scores
 * @property Doctrine_Collection $Flags
 * 
 * @method string              getTopics()            Returns the current record's "topics" value
 * @method string              getContent()           Returns the current record's "content" value
 * @method string              getNote()              Returns the current record's "note" value
 * @method integer             getVersion()           Returns the current record's "version" value
 * @method integer             getScore()             Returns the current record's "score" value
 * @method bool                getIsActive()          Returns the current record's "is_active" value
 * @method enum                getEditType()          Returns the current record's "edit_type" value
 * @method bool                getEditLock()          Returns the current record's "edit_lock" value
 * @method datetime            getEditLockStart()     Returns the current record's "edit_lock_start" value
 * @method datetime            getEditLockTime()      Returns the current record's "edit_lock_time" value
 * @method integer             getEditLockUserId()    Returns the current record's "edit_lock_user_id" value
 * @method bool                getLockCode()          Returns the current record's "lock_code" value
 * @method integer             getGroupId()           Returns the current record's "group_id" value
 * @method sfGuardUser         getUser()              Returns the current record's "User" value
 * @method Doctrine_Collection getLimelights()        Returns the current record's "Limelights" collection
 * @method Doctrine_Collection getLimelightWikis()    Returns the current record's "LimelightWikis" collection
 * @method Doctrine_Collection getComments()          Returns the current record's "Comments" collection
 * @method Doctrine_Collection getUserAction()        Returns the current record's "UserAction" collection
 * @method Doctrine_Collection getScores()            Returns the current record's "Scores" collection
 * @method Doctrine_Collection getFlags()             Returns the current record's "Flags" collection
 * @method Wiki                setTopics()            Sets the current record's "topics" value
 * @method Wiki                setContent()           Sets the current record's "content" value
 * @method Wiki                setNote()              Sets the current record's "note" value
 * @method Wiki                setVersion()           Sets the current record's "version" value
 * @method Wiki                setScore()             Sets the current record's "score" value
 * @method Wiki                setIsActive()          Sets the current record's "is_active" value
 * @method Wiki                setEditType()          Sets the current record's "edit_type" value
 * @method Wiki                setEditLock()          Sets the current record's "edit_lock" value
 * @method Wiki                setEditLockStart()     Sets the current record's "edit_lock_start" value
 * @method Wiki                setEditLockTime()      Sets the current record's "edit_lock_time" value
 * @method Wiki                setEditLockUserId()    Sets the current record's "edit_lock_user_id" value
 * @method Wiki                setLockCode()          Sets the current record's "lock_code" value
 * @method Wiki                setGroupId()           Sets the current record's "group_id" value
 * @method Wiki                setUser()              Sets the current record's "User" value
 * @method Wiki                setLimelights()        Sets the current record's "Limelights" collection
 * @method Wiki                setLimelightWikis()    Sets the current record's "LimelightWikis" collection
 * @method Wiki                setComments()          Sets the current record's "Comments" collection
 * @method Wiki                setUserAction()        Sets the current record's "UserAction" collection
 * @method Wiki                setScores()            Sets the current record's "Scores" collection
 * @method Wiki                setFlags()             Sets the current record's "Flags" collection
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseWiki extends Item
{
    public function setTableDefinition()
    {
        parent::setTableDefinition();
        $this->setTableName('wiki');
        $this->hasColumn('topics', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('content', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('note', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('version', 'integer', 4, array(
             'type' => 'integer',
             'default' => 1,
             'length' => 4,
             ));
        $this->hasColumn('score', 'integer', 4, array(
             'type' => 'integer',
             'default' => 0,
             'length' => 4,
             ));
        $this->hasColumn('is_active', 'bool', null, array(
             'type' => 'bool',
             'default' => 0,
             ));
        $this->hasColumn('edit_type', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'minor',
              1 => 'major',
             ),
             'default' => 'minor',
             ));
        $this->hasColumn('edit_lock', 'bool', null, array(
             'type' => 'bool',
             'default' => 0,
             ));
        $this->hasColumn('edit_lock_start', 'datetime', null, array(
             'type' => 'datetime',
             ));
        $this->hasColumn('edit_lock_time', 'datetime', null, array(
             'type' => 'datetime',
             ));
        $this->hasColumn('edit_lock_user_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('lock_code', 'bool', null, array(
             'type' => 'bool',
             'default' => 0,
             ));
        $this->hasColumn('group_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));


        $this->index('groupIndex', array(
             'fields' => 
             array(
              0 => 'group_id',
              1 => 'version',
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

        $this->hasMany('Limelight as Limelights', array(
             'refClass' => 'LimelightWiki',
             'local' => 'wiki_group_id',
             'foreign' => 'limelight_id'));

        $this->hasMany('LimelightWiki as LimelightWikis', array(
             'local' => 'group_id',
             'foreign' => 'wiki_group_id'));

        $this->hasMany('Comment as Comments', array(
             'local' => 'id',
             'foreign' => 'Wiki_id'));

        $this->hasMany('UserAction', array(
             'local' => 'id',
             'foreign' => 'Wiki_id'));

        $this->hasMany('WikiScore as Scores', array(
             'local' => 'id',
             'foreign' => 'item_id'));

        $this->hasMany('WikiFlag as Flags', array(
             'local' => 'id',
             'foreign' => 'item_id'));
    }
}