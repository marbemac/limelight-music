<?php


class NewsLinkTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('NewsLink');
    }

    public function getLinks($news_id)
    {
      $q = Doctrine_Query::create()
          ->select('nl.*, s.name, s.name_slug, u.id')
          ->from('NewsLink nl')
          ->leftJoin('nl.Source s')
          ->leftJoin('nl.User u')
          ->where('nl.item_id = ? AND s.status = ? AND nl.status = ?', array($news_id, 'Active', 'Active'))
          ->orderBy('nl.score DESC')
          ->addOrderBy('nl.created_at ASC')
          ->useResultCache(true, 3600, 'news_links_'.$news_id);
      return $q->fetchArray();
    }

    public function checkDuplicate($source_name, $source_url, $news_id)
    {
      $q = Doctrine_Query::create()
          ->select('nl.id, s.id')
          ->from('NewsLink nl')
          ->leftJoin('nl.Source s')
          ->where('nl.source_url_slug = ? OR (nl.item_id = ? AND s.name_slug = ?)', array(LimelightUtils::slugify($source_url), $news_id, LimelightUtils::slugify($source_name)));

      return $q->fetchOne();
    }
}