<?php


class SongViewTable extends ViewTable
{
  public function getUserDailyViews($name_slug, $user_id, $date)
  {
    $q = Doctrine_Query::create()
        ->select('s.id, sv.count')
        ->from('Song s')
        ->leftJoin('s.Views sv WITH sv.user_id = ? AND DATE(sv.created_at) = ?', array($user_id, $date))
        ->where('s.name_slug = ?', $name_slug);
    return $q->fetchOne();
  }

  public function getDailyViews($song_id, $date)
  {
    $q = Doctrine_Query::create()
        ->select('SUM(count) as count')
        ->from('SongView')
        ->where('item_id = ? AND DATE(created_at) = ?', array($song_id, $date));

    return $q->fetchOne();
  }
}