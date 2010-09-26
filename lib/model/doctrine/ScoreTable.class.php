<?php

class ScoreTable extends Doctrine_Table
{
  public function checkScored($item_type, $item_id, $user_id) {
    $q = Doctrine_Query::create()
        ->select('id, amount, item_id, created_at')
        ->from($item_type)
        ->where('item_id = ? AND user_id = ?', array($item_id, $user_id));
    return $q->fetchOne();
  }

  /**
  * fetches and builds the chart data based on the google chart api
  *
  * @param item_type $item_type the type of the item (Limelight, News, etc). Must be capital letter and have corresponding 'app_(item_type)_chart_stat_pullback'
   * constant defined in the app file
  * @param item_id $item_id
  */
  public function getScoreChartData($item_type, $item_id)
  {
    $q = Doctrine_Query::create()
        ->select('SUM(s.amount) AS increase, DATE_FORMAT(s.created_at, "%c-%e") AS date')
        ->from(ucfirst($item_type).'Score s')
        ->where('s.item_id = ? AND UNIX_TIMESTAMP(s.created_at) >= ?', array($item_id, time() - sfConfig::get('app_'.$item_type.'_chart_stat_pullback')))
        ->groupBy('DATE_FORMAT(s.created_at, "%d/%m/%Y")')
        ->orderBy('date DESC');
    $result = $q->fetchArray();

    return $result;
  }

  // check to see if this is the first time a user has downvoted an item
  public function checkFirstUserDownvote($user_id)
  {
    $q = Doctrine_Query::create()
        ->select('id')
        ->from('UserScore')
        ->where('user_id = ? AND amount < 0', $user_id)
        ->limit(2);
    $result = $q->fetchArray();

    return $result;
  }
}