<?php

/**
 * NewsTagScore
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class NewsTagScore extends BaseNewsTagScore
{
  public function postSave($event)
  {
    $cacheDriver = $this->getTable()->getAttribute(Doctrine_Core::ATTR_RESULT_CACHE);
    $cacheDriver->delete('news_tags_'.$this->item_id);
  }
}