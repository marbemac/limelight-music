<?php

/**
 * BaseNewsViews
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $count
 * @property integer $news_id
 * @property integer $user_id
 * @property News $News
 * 
 * @method integer   getCount()   Returns the current record's "count" value
 * @method integer   getNewsId()  Returns the current record's "news_id" value
 * @method integer   getUserId()  Returns the current record's "user_id" value
 * @method News      getNews()    Returns the current record's "News" value
 * @method NewsViews setCount()   Sets the current record's "count" value
 * @method NewsViews setNewsId()  Sets the current record's "news_id" value
 * @method NewsViews setUserId()  Sets the current record's "user_id" value
 * @method NewsViews setNews()    Sets the current record's "News" value
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseNewsViews extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('news_views');
        $this->hasColumn('count', 'integer', 11, array(
             'type' => 'integer',
             'default' => 1,
             'length' => '11',
             ));
        $this->hasColumn('news_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('News', array(
             'local' => 'news_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}