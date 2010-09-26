<?php

/**
 * BaseNewsLinkScore
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property NewsLink $Item
 * 
 * @method NewsLink      getItem() Returns the current record's "Item" value
 * @method NewsLinkScore setItem() Sets the current record's "Item" value
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseNewsLinkScore extends Score
{
    public function setTableDefinition()
    {
        parent::setTableDefinition();
        $this->setTableName('news_link_score');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('NewsLink as Item', array(
             'local' => 'item_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}