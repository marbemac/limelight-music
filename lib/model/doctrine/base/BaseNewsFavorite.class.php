<?php

/**
 * BaseNewsFavorite
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property sfGuardUser $User
 * @property News $Item
 * 
 * @method sfGuardUser  getUser() Returns the current record's "User" value
 * @method News         getItem() Returns the current record's "Item" value
 * @method NewsFavorite setUser() Sets the current record's "User" value
 * @method NewsFavorite setItem() Sets the current record's "Item" value
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseNewsFavorite extends Favorite
{
    public function setTableDefinition()
    {
        parent::setTableDefinition();
        $this->setTableName('news_favorite');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('sfGuardUser as User', array(
             'local' => 'user_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('News as Item', array(
             'local' => 'item_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}