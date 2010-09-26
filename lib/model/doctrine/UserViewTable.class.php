<?php

class UserViewTable extends ViewTable
{
  public function getUserDailyViews($username, $user_id, $date)
  {
    $q = Doctrine_Query::create()
        ->select('u.id, uv.id, uv.count, p.total_views')
        ->from('sfGuardUser u')
        ->leftJoin('u.Views uv WITH uv.user_id = ? AND DATE(uv.created_at) = ?', array($user_id, $date))
        ->where('u.username = ?', $username);
    return $q->fetchOne();
  }

  public function getDailyViews($user_id, $date)
  {
    $q = Doctrine_Query::create()
        ->select('SUM(count) as count')
        ->from('UserView')
        ->where('target_user_id = ? AND DATE(created_at) = ?', array($user_id, $date));
    return $q->fetchOne();
  }
}