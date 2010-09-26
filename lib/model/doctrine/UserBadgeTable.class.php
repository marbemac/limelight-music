<?php

class UserBadgeTable extends Doctrine_Table
{
  public function getUserBadgeLevels($user_id) {
    $q = Doctrine_Query::create()
        ->select('count(id) AS badge_count, level_completed')
        ->from('UserBadge')
        ->groupBy('level_completed')
        ->orderBy('level_completed ASC')
        ->where('user_id = ? AND level_completed != ?', array($user_id, 0));
    $q->useResultCache(true, 3600, 'user_'.$user_id.'_badgelevels');
    return $q->fetchArray();
  }
}