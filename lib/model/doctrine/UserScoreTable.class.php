<?php

class UserScoreTable extends Doctrine_Table
{
  // reduce the user score after an item that contributed to their score is flagged
  public function flagScores($item_type, $item_id, $target_user_id)
  {
    $q = Doctrine_Query::create()
        ->update('UserScore')
        ->set('status', '?', 'Flagged')
        ->where('type = ? AND item_id = ? AND target_user_id = ?', array($item_type, $item_id, $target_user_id))
        ->execute();
  }

  public function getUserStats($user_id, $days=0)
  {
    $past = 0;
    if ($days != 0)
    {
      $past = time() - (60 * 60 * 24 * $days);
    }

    $stats = array('overall_stats', 'segmented_stats', 'overall_rated_stats', 'segmented_rated_stats', 'overall_follower_stat');

    // *** get the overall stats
    $q = Doctrine_Query::create()
      ->select('amount, SUM(amount) as score_change')
      ->from('UserScore')
      ->where('target_user_id = ? AND UNIX_TIMESTAMP(created_at) >= ? AND status = ?', array($user_id, $past, 'Active'))
      ->groupBy('amount')
      ->useResultCache(true, 120, 'user_stats_overall_'.$user_id.'_'.$days);
    $result = $q->fetchArray();

    $stats['overall_stats'] = array('overall' => 0, 'up' => 0, 'down' => 0);
    foreach ($result as $stat)
    {
      if ($stat['score_change'] > 0)
        $stats['overall_stats']['up'] += $stat['score_change'];
      else
        $stats['overall_stats']['down'] += $stat['score_change'];
      $stats['overall_stats']['overall'] += $stat['score_change'];
    }

    // *** get the overall stats
    $q = Doctrine_Query::create()
      ->select('COUNT(*) as follower_change')
      ->from('FollowUserReference')
      ->where('user2_id = ? AND UNIX_TIMESTAMP(created_at) >= ?', array($user_id, 'Active'))
      ->useResultCache(true, 120, 'user_stats_following_'.$user_id.'_'.$days);
    $result = $q->fetchOne();

    $stats['follower_stat'] = array('overall' => $result['follower_change']);

    // *** get the rated overall stats
    $q = Doctrine_Query::create()
      ->select('amount, SUM(amount) as score_change')
      ->from('UserScore')
      ->where('user_id = ? AND UNIX_TIMESTAMP(created_at) >= ? AND status = ?', array($user_id, $past, 'Active'))
      ->groupBy('amount')
      ->useResultCache(true, 120, 'user_stats_overall_rated_'.$user_id.'_'.$days);
    $result = $q->fetchArray();

    $stats['overall_rated_stats'] = array('overall' => 0, 'up' => 0, 'down' => 0);
    foreach ($result as $stat)
    {
      if ($stat['score_change'] > 0)
        $stats['overall_rated_stats']['up'] += $stat['score_change'];
      else
        $stats['overall_rated_stats']['down'] += $stat['score_change'];
      $stats['overall_rated_stats']['overall'] += $stat['score_change'];
    }

    // *** get the segmented contributed items
    $q = Doctrine_Query::create()
      ->select('type, count(id) as contributed')
      ->from('UserAction')
      ->where('user_id = ? AND UNIX_TIMESTAMP(created_at) >= ? AND status = ?', array($user_id, $past, 'Active'))
      ->groupBy('type')
      ->useResultCache(true, 120, 'user_stats_contributed_'.$user_id.'_'.$days);
    $result = $q->fetchArray();

    $stats['contributed_stats'] = array(
        'News' => 0,
        'Comment' => 0,
        'LimelightProCon' => 0,
        'badge' => 0,
        'NewsTag' => 0,
        'LimelightSpecification' => 0,
        'Wiki' => 0,
        'NewsLink' => 0,
        'Limelight' => 0,
    );
    foreach ($result as $stat)
    {
      $stats['contributed_stats'][$stat['type']] += $stat['contributed'];
    }

    // *** get the segmented overall stats
    $q = Doctrine_Query::create()
      ->select('type, SUM(amount) as score_change')
      ->from('UserScore')
      ->where('target_user_id = ? AND UNIX_TIMESTAMP(created_at) >= ? AND status = ?', array($user_id, $past, 'Active'))
      ->groupBy('type')
      ->addGroupBy('amount')
      ->useResultCache(true, 120, 'user_stats_segmented_'.$user_id.'_'.$days);
    $result = $q->fetchArray();

    $stats['segmented_stats'] = array(
        'News' => array('up' => 0, 'overall' => 0, 'down' => 0),
        'Comment' => array('up' => 0, 'overall' => 0, 'down' => 0),
        'LimelightProCon' => array('up' => 0, 'overall' => 0, 'down' => 0),
        'badge' => array('up' => 0, 'overall' => 0, 'down' => 0),
        'NewsTag' => array('up' => 0, 'overall' => 0, 'down' => 0),
        'LimelightSpecification' => array('up' => 0, 'overall' => 0, 'down' => 0),
        'Wiki' => array('up' => 0, 'overall' => 0, 'down' => 0),
        'NewsLink' => array('up' => 0, 'overall' => 0, 'down' => 0)
    );

    foreach ($result as $stat)
    {
      if ($stat['score_change'] > 0)
        $stats['segmented_stats'][$stat['type']]['up'] += $stat['score_change'];
      else
        $stats['segmented_stats'][$stat['type']]['down'] += $stat['score_change'];
      $stats['segmented_stats'][$stat['type']]['overall'] += $stat['score_change'];
    }

    // *** get the segmented rated stats
    $q = Doctrine_Query::create()
      ->select('type, SUM(amount) as score_change')
      ->from('UserScore')
      ->where('user_id = ? AND UNIX_TIMESTAMP(created_at) >= ? AND status = ?', array($user_id, $past, 'Active'))
      ->groupBy('type')
      ->useResultCache(true, 120, 'user_stats_segmented_rated_'.$user_id.'_'.$days);
    $result = $q->fetchArray();

    $stats['segmented_rated_stats'] = array(
        'News' => array('up' => 0, 'overall' => 0, 'down' => 0),
        'Comment' => array('up' => 0, 'overall' => 0, 'down' => 0),
        'LimelightProCon' => array('up' => 0, 'overall' => 0, 'down' => 0),
        'badge' => array('up' => 0, 'overall' => 0, 'down' => 0),
        'NewsTag' => array('up' => 0, 'overall' => 0, 'down' => 0),
        'LimelightSpecification' => array('up' => 0, 'overall' => 0, 'down' => 0),
        'Wiki' => array('up' => 0, 'overall' => 0, 'down' => 0),
        'NewsLink' => array('up' => 0, 'overall' => 0, 'down' => 0)
    );

    foreach ($result as $stat)
    {
      if ($stat['score_change'] > 0)
        $stats['segmented_rated_stats'][$stat['type']]['up'] += $stat['score_change'];
      else
        $stats['segmented_rated_stats'][$stat['type']]['down'] += $stat['score_change'];
      $stats['segmented_rated_stats'][$stat['type']]['overall'] += $stat['score_change'];
    }

    return $stats;
  }

  public function getUserRatedOverallStats($user_id, $days=0)
  {
    $past = 0;
    if ($days != 0)
    {
      $past = time() - (60 * 60 * 24 * $days);
    }

    $q = Doctrine_Query::create()
      ->select('SUM(amount) as score_change')
      ->from('UserScore')
      ->where('user_id = ? AND UNIX_TIMESTAMP(created_at) >= ? AND status = ?', array($user_id, $past, 'Active'))
      ->useResultCache(true, 120, 'user_stats_overall_rated_'.$user_id.'_'.$days);
    $result = $q->fetchArray();

    $stats = array('overall' => 0, 'pos' => 0, 'neg' => 0);
    foreach ($result as $stat)
    {
      if ($stat['score_change'] > 0)
        $stats['pos'] += $stat['score_change'];
      else
        $stats['neg'] += $stat['score_change'];
      $stats['overall'] += $stat['score_change'];
    }

    return $stats;
  }

  public function getUserSegmentedStats($user_id, $days=0)
  {
    $past = 0;
    if ($days != 0)
    {
      $past = time() - (60 * 60 * 24 * $days);
    }

    $q = Doctrine_Query::create()
      ->select('type, SUM(amount) as score_change')
      ->from('UserScore')
      ->where('target_user_id = ? AND UNIX_TIMESTAMP(created_at) >= ? AND status = ?', array($user_id, $past, 'Active'))
      ->groupBy('type')
      ->useResultCache(true, 120, 'user_stats_segmented_'.$user_id.'_'.$days);
    $result = $q->fetchArray();

    $stats = array('News' => 0, 'Comment' => 0, 'LimelightProCon' => 0, 'badge' => 0, 'NewsTag' => 0, 'LimelightSpecification' => 0, 'Wiki' => 0, 'NewsLink' => 0);

    foreach ($result as $stat)
    {
      $stats[$stat['type']] += $stat['score_change'];
    }

    return $stats;
  }

  public function getUserRatedSegmentedStats($user_id, $days=0)
  {
    $past = 0;
    if ($days != 0)
    {
      $past = time() - (60 * 60 * 24 * $days);
    }

    $q = Doctrine_Query::create()
      ->select('type, SUM(amount) as score_change')
      ->from('UserScore')
      ->where('user_id = ? AND UNIX_TIMESTAMP(created_at) >= ? AND status = ?', array($user_id, $past, 'Active'))
      ->groupBy('type')
      ->useResultCache(true, 120, 'user_stats_segmented_rated_'.$user_id.'_'.$days);
    $result = $q->fetchArray();

    $stats = array('News' => 0, 'Comment' => 0, 'LimelightProCon' => 0, 'NewsTag' => 0, 'LimelightSpecification' => 0, 'Wiki' => 0, 'NewsLink' => 0, 'badge' => 0);

    foreach ($result as $stat)
    {
      $stats[$stat['type']] += $stat['score_change'];
    }

    return $stats;
  }
}