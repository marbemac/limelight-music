<?php

class UserActionTable extends Doctrine_Table
{
  // what is available (kind of)?
  private $action_types = array('Limelight', 'News', 'Comment', 'LimelightProCon', 'LimelightWiki',
                         'LimelightReviewUser', 'LimelightReviewPro', 'Song');

  // what are we currently showing in the feeds?
  private $current_types = array('Limelight', 'News', 'Comment', 'Song');

  public function getMainfeed($type, $period, $sort_by, $categories, $limit, $offset) {
    $q = Doctrine_Query::create()
        ->select('ua.*')
        ->from('UserAction ua')
        ->where('ua.status = ?', array('Active'))
        ->andWhereIn('ua.type', $this->current_types)
        ->orderBy('ua.created_at DESC')
        ->limit($limit)
        ->offset($offset);
    $q->useResultCache(true, 30, 'mainfeed_'.$limit.'_'.$offset);
    return $q->fetchArray();
  }

  /*
   * return a list of user actions with their associated objects polymorphically
   * loaded into the results array.
   */
  public function getMinifeed($user_id, $limit, $offset) {
    $q = Doctrine_Query::create()
        ->select('ua.*')
        ->from('UserAction ua')
        ->where('ua.user_id = ? AND ua.status = ?', array($user_id, 'Active'))
        ->andWhereIn('ua.type', $this->current_types)
        ->orderBy('ua.created_at DESC')
        ->limit($limit)
        ->offset($offset);
    $q->useResultCache(true, 300, 'user_'.$user_id.'_minifeed_'.$limit.'_'.$offset);
    return $q->fetchArray();
  }

  public function getFollowingFeed($user_id, $limit, $offset, $following) {
    if (count($following) == 0)
      return array();

    $following_ids = array();
    foreach ($following as $key => $user)
      $following_ids[$key] = $user['user2_id'];
    sort($following_ids, SORT_NUMERIC);

    $q = Doctrine_Query::create()
        ->select('ua.*')
        ->from('UserAction ua')
        ->where('ua.status = ?', 'Active')
        ->andWhereIn('ua.user_id', $following_ids)
        ->andWhereIn('ua.type', $this->current_types)
        ->orderBy('ua.created_at DESC')
        ->limit($limit)
        ->offset($offset);
    $q->useResultCache(true, 300, 'user_'.$user_id.'_followingfeed_'.$limit.'_'.$offset);
    return $q->fetchArray();
  }

  public function flagItem($user_id, $item_id, $item_type)
  {
    $q = Doctrine_Query::create()
    ->update('UserAction')
    ->set('status', '?', 'Flagged')
    ->where('user_id = ? AND '.$item_type.'_id = ? AND type = ?', array($user_id, $item_id, $item_type));
    $q->execute();
  }
}