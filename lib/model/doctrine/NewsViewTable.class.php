<?php

class NewsViewTable extends ViewTable
{
  public function getUserDailyViews($title_slug, $user_id, $date)
  {
    $q = Doctrine_Query::create()
        ->select('n.id, nv.id, nv.count')
        ->from('News n')
        ->leftJoin('n.Views nv WITH nv.user_id = ? AND DATE(nv.created_at) = ?', array($user_id, $date))
        ->where('n.title_slug = ?', $title_slug);
    return $q->fetchOne();
  }

  public function getDailyViews($news_id, $date)
  {
    $q = Doctrine_Query::create()
        ->select('SUM(count) as count')
        ->from('NewsView')
        ->where('news_id = ? AND DATE(created_at) = ?', array($news_id, $date));
    return $q->fetchOne();
  }
}