<?php

class BadgeTable extends Doctrine_Table
{
  public function getUserBadges($user_id) {
    $q = Doctrine_Query::create()
        ->select('b.*, ub.*, bl.*')
        ->from('Badge b')
        ->leftJoin('b.UserBadges ub WITH ub.user_id = ?', $user_id)
        ->leftJoin('b.BadgeLevels bl')
        ->where('b.status = ?', 'Active')
        ->orderBy('b.type ASC')
        ->addOrderBy('b.name ASC');
    $q->useResultCache(true, 3600, 'user_'.$user_id.'_badges');
    return $q->fetchArray();
  }

  public function increaseBadgeStat($name, $user_id) {
    $q = Doctrine_Query::create()
        ->select('b.*, ub.*, bl.*')
        ->from('Badge b')
        ->leftJoin('b.BadgeLevels bl')
        ->where('b.name = ?', array($name));
    $badge = $q->fetchOne();

    $q = Doctrine_Query::create()
        ->select('*')
        ->from('UserBadge')
        ->where('user_id = ? AND badge_id = ?', array($user_id, $badge['id']));
    $user_badge = $q->fetchOne();

    if ($user_badge['level_completed'] == $badge['BadgeLevels'][count($badge['BadgeLevels'])-1]['level'])
      return;

    $user_badge['num_completed'] += 1;
    if ($user_badge['num_completed'] == $badge['BadgeLevels'][$user_badge['level_completed']]['num_required']) {
      $user_badge['level_completed'] += $badge['BadgeLevels'][$user_badge['level_completed']]['level'];
      $us = new UserScore();
      $us->amount = sfConfig::get('app_badge_score_'.LimelightUtils::getBadgeName($user_badge['level_completed']-1));
      $us->type = 'badge';
      $us->target_user_id = $user_id;
      $us->save();
      $n = new UserNotification();
      $n->type = 'badge';
      $n->message = 'congrats, you\'ve earned the ' . LimelightUtils::getBadgeName($user_badge['level_completed']-1) . ' ' . $name . ' badge!';
      $n->user_id = $user_id;
      $n->save();

      if ($user_badge['level_completed'] == $badge['BadgeLevels'][count($badge['BadgeLevels'])-1]['level']) {
        if ($user_badge['level_completed'] == sfConfig::get('app_badge_num_levels')) {
          $s = new UserScore();
          $s->amount = sfConfig::get('app_badge_extra_score');
          $s->target_user_id = $user_id;
          $s->type = 'badge';
          $s->save();
        }
        if ($name != 'Nerd')
          $this->increaseBadgeStat('Nerd', $user_id);
      }
    }
    $user_badge->save();
  }

  public function decreaseBadgeStat($name, $user_id) {
    $q = Doctrine_Query::create()
        ->select('b.*, ub.*, bl.*')
        ->from('Badge b')
        ->leftJoin('b.UserBadges ub WITH ub.user_id = ?', $user_id)
        ->leftJoin('b.BadgeLevels bl')
        ->where('b.name = ?', array($name));
    $badge = $q->fetchOne();

    if ($badge['UserBadges'][0]['num_completed'] == 0 || $badge['UserBadges'][0]['level_completed'] == $badge['BadgeLevels'][count($badge['BadgeLevels'])-1]['level'])
      return;

    $badge['UserBadges'][0]['num_completed'] -= 1;
    $badge->save();
  }

  public function setBadgeStat($name, $user_id, $value) {
    $q = Doctrine_Query::create()
        ->select('b.*, ub.*')
        ->from('Badge b')
        ->leftJoin('b.UserBadges ub WITH ub.user_id = ?', $user_id)
        ->where('b.name = ?', array($name));
    $badge = $q->fetchOne();

    $badge['UserBadges'][0]['num_completed'] = $value;
    $badge->save();
  }
}