<?php

class ViewTable extends Doctrine_Table
{
  /**
  * fetches and builds the chart data based on the google chart api
  *
  * @param item_type $item_type the type of the item (Limelight, News, etc). Must be capital letter and have corresponding 'app_(item_type)_chart_stat_pullback'
   * constant defined in the app file
  * @param item_id $item_id
  */
  public function getViewChartData($item_type, $item_id)
  {
    $q = Doctrine_Query::create()
        ->select('SUM(v.count) AS increase, DATE_FORMAT(v.created_at, "%c-%e") AS date')
        ->from(ucfirst($item_type).'View v')
        ->where('v.item_id = ? AND UNIX_TIMESTAMP(v.created_at) >= ?', array($item_id, time() - sfConfig::get('app_'.$item_type.'_chart_stat_pullback')))
        ->groupBy('DATE_FORMAT(v.created_at, "%d/%m/%Y")')
        ->orderBy('date DESC');
    $result = $q->fetchArray();

    return $result;
  }
}