<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class NewsFavorite extends BaseNewsFavorite
{
  public function postSave($event)
  {
    $cacheDriver = $this->getTable()->getAttribute(Doctrine_Core::ATTR_RESULT_CACHE);
    $cacheDriver->delete('news_stats_'.$this->item_id.'_'.$this->user_id);
  }
}