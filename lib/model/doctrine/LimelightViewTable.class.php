<?php

class LimelightViewTable extends ViewTable
{
  public function getUserDailyViews($name_slug, $user_id, $date)
  {
    $q = Doctrine_Query::create()
        ->select('ll.id, lv.count')
        ->from('Limelight ll')
        ->leftJoin('ll.Views lv WITH lv.user_id = ? AND DATE(lv.created_at) = ?', array($user_id, $date))
        ->where('ll.name_slug = ?', $name_slug);
    return $q->fetchOne();
  }

  public function getDailyViews($limelight_id, $date)
  {
    $q = Doctrine_Query::create()
        ->select('SUM(count) as count')
        ->from('LimelightView')
        ->where('limelight_id = ? AND DATE(created_at) = ?', array($limelight_id, $date));

    return $q->fetchOne();
  }
}