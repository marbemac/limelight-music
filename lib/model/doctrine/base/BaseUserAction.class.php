<?php

/**
 * BaseUserAction
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $Limelight_id
 * @property integer $News_id
 * @property integer $Comment_id
 * @property integer $LimelightProCon_id
 * @property integer $Wiki_id
 * @property integer $LimelightReviewUser_id
 * @property integer $LimelightReviewPro_id
 * @property integer $LimelightSpecification_id
 * @property integer $NewsTag_id
 * @property string $type
 * @property integer $user_id
 * @property enum $status
 * @property sfGuardUser $User
 * @property Limelight $Limelights
 * @property News $News
 * @property Comment $Comments
 * @property LimelightProCon $LimelightProcons
 * @property Wiki $Wikis
 * @property LimelightReviewUser $LimelightUserReviews
 * @property LimelightReviewPro $LimelightProReviews
 * @property LimelightSpecification $LimelightSpecifications
 * 
 * @method integer                getId()                        Returns the current record's "id" value
 * @method integer                getLimelightId()               Returns the current record's "Limelight_id" value
 * @method integer                getNewsId()                    Returns the current record's "News_id" value
 * @method integer                getCommentId()                 Returns the current record's "Comment_id" value
 * @method integer                getLimelightProConId()         Returns the current record's "LimelightProCon_id" value
 * @method integer                getWikiId()                    Returns the current record's "Wiki_id" value
 * @method integer                getLimelightReviewUserId()     Returns the current record's "LimelightReviewUser_id" value
 * @method integer                getLimelightReviewProId()      Returns the current record's "LimelightReviewPro_id" value
 * @method integer                getLimelightSpecificationId()  Returns the current record's "LimelightSpecification_id" value
 * @method integer                getNewsTagId()                 Returns the current record's "NewsTag_id" value
 * @method string                 getType()                      Returns the current record's "type" value
 * @method integer                getUserId()                    Returns the current record's "user_id" value
 * @method enum                   getStatus()                    Returns the current record's "status" value
 * @method sfGuardUser            getUser()                      Returns the current record's "User" value
 * @method Limelight              getLimelights()                Returns the current record's "Limelights" value
 * @method News                   getNews()                      Returns the current record's "News" value
 * @method Comment                getComments()                  Returns the current record's "Comments" value
 * @method LimelightProCon        getLimelightProcons()          Returns the current record's "LimelightProcons" value
 * @method Wiki                   getWikis()                     Returns the current record's "Wikis" value
 * @method LimelightReviewUser    getLimelightUserReviews()      Returns the current record's "LimelightUserReviews" value
 * @method LimelightReviewPro     getLimelightProReviews()       Returns the current record's "LimelightProReviews" value
 * @method LimelightSpecification getLimelightSpecifications()   Returns the current record's "LimelightSpecifications" value
 * @method UserAction             setId()                        Sets the current record's "id" value
 * @method UserAction             setLimelightId()               Sets the current record's "Limelight_id" value
 * @method UserAction             setNewsId()                    Sets the current record's "News_id" value
 * @method UserAction             setCommentId()                 Sets the current record's "Comment_id" value
 * @method UserAction             setLimelightProConId()         Sets the current record's "LimelightProCon_id" value
 * @method UserAction             setWikiId()                    Sets the current record's "Wiki_id" value
 * @method UserAction             setLimelightReviewUserId()     Sets the current record's "LimelightReviewUser_id" value
 * @method UserAction             setLimelightReviewProId()      Sets the current record's "LimelightReviewPro_id" value
 * @method UserAction             setLimelightSpecificationId()  Sets the current record's "LimelightSpecification_id" value
 * @method UserAction             setNewsTagId()                 Sets the current record's "NewsTag_id" value
 * @method UserAction             setType()                      Sets the current record's "type" value
 * @method UserAction             setUserId()                    Sets the current record's "user_id" value
 * @method UserAction             setStatus()                    Sets the current record's "status" value
 * @method UserAction             setUser()                      Sets the current record's "User" value
 * @method UserAction             setLimelights()                Sets the current record's "Limelights" value
 * @method UserAction             setNews()                      Sets the current record's "News" value
 * @method UserAction             setComments()                  Sets the current record's "Comments" value
 * @method UserAction             setLimelightProcons()          Sets the current record's "LimelightProcons" value
 * @method UserAction             setWikis()                     Sets the current record's "Wikis" value
 * @method UserAction             setLimelightUserReviews()      Sets the current record's "LimelightUserReviews" value
 * @method UserAction             setLimelightProReviews()       Sets the current record's "LimelightProReviews" value
 * @method UserAction             setLimelightSpecifications()   Sets the current record's "LimelightSpecifications" value
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseUserAction extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('user_action');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('Limelight_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('News_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('Comment_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('LimelightProCon_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('Wiki_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('LimelightReviewUser_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('LimelightReviewPro_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('LimelightSpecification_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('NewsTag_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('type', 'string', 30, array(
             'type' => 'string',
             'length' => 30,
             ));
        $this->hasColumn('user_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('status', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'Active',
              1 => 'Pending',
              2 => 'Flagged',
              3 => 'Struck',
              4 => 'Disabled',
             ),
             'default' => 'Active',
             ));


        $this->index('userIndex', array(
             'fields' => 
             array(
              0 => 'user_id',
             ),
             ));
        $this->index('itemIndex', array(
             'fields' => 
             array(
              0 => 'type',
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

        $this->hasOne('Limelight as Limelights', array(
             'local' => 'Limelight_id',
             'foreign' => 'id'));

        $this->hasOne('News', array(
             'local' => 'News_id',
             'foreign' => 'id'));

        $this->hasOne('Comment as Comments', array(
             'local' => 'Comment_id',
             'foreign' => 'id'));

        $this->hasOne('LimelightProCon as LimelightProcons', array(
             'local' => 'LimelightProCon_id',
             'foreign' => 'id'));

        $this->hasOne('Wiki as Wikis', array(
             'local' => 'Wiki_id',
             'foreign' => 'id'));

        $this->hasOne('LimelightReviewUser as LimelightUserReviews', array(
             'local' => 'LimelightReviewUser_id',
             'foreign' => 'id'));

        $this->hasOne('LimelightReviewPro as LimelightProReviews', array(
             'local' => 'LimelightReviewPro_id',
             'foreign' => 'id'));

        $this->hasOne('LimelightSpecification as LimelightSpecifications', array(
             'local' => 'LimelightSpecification_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}