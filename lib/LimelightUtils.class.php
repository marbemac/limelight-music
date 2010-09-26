<?php

sfProjectConfiguration::getActive()->loadHelpers('Url');

class LimelightUtils
{
  static public function slugify($text)
  {
    // replace all non letters or digits by -
    $text = preg_replace('/\W+/', '-', $text);

    // trim and lowercase
    $text = strtolower(trim($text, '-'));

    return $text;
  }

  static public function timeLapse($end, $start=null, $after=' ago')
  {
    //both times must be in seconds
    $end = strtotime($end);
    if ($start == null)
      $start = time();
    $time = $start - $end;
    if ($time <= 60)
      return 'just now';
	else if ($time <= 3600)
      return round($time/60).' minutes'.$after;
	else if ($time <= 86400)
      return round($time/3600).' hours'.$after;
	else if ($time <= 604800)
      return round($time/86400).' days'.$after;
	if ($time <= 2592000)
      return round($time/604800).' weeks'.$after;
	else if ($time <= 29030400)
      return round($time/2592000).' months'.$after;
	else if ($time > 29030400)
      return round($time/31526000).' year, '.round(($time-31526000)/2592000).' months'.$after;
    else
      return 'error';
  }

  // legacy news link builder, built link based on news categories
//  static public function buildNewsLink($link_name, $route_name, $newsItem)
//  {
//    $options['title_slug'] = $newsItem['title_slug'];
//
//    $categories = Doctrine::getTable('news')->findOneById($newsItem['id'])->Categories;
//    foreach ($categories as $key => $category)
//      $options['cat_' . $key] = $category['name_slug'];
//    return link_to($link_name, $route_name.'_'.count($categories), $options);
//  }

//  static public function buildCacheKey($user, $type = 'basic') {
//    if ($user->isAuthenticated()) {
//      if ($type == 'basic')
//      {
//        if ($user->hasGroup('admin') || $user->hasGroup('supermod'))
//          return 'mod';
//      }
//      else
//      {
//        $groups = $user->getGuardUser()->getGroups();
//        foreach ($groups as $group) {
//          if ($group == 'admin')
//            return '-admin';
//          else if ($group == 'moderator2')
//            return '-mod2';
//          else if ($group == 'moderator1')
//            return '-mod1';
//        }
//      }
//      return '-logged';
//    } else
//      return '-notlogged';
//  }

  static public function getNotificationCount($user_id) {
    return count(Doctrine::getTable('UserNotification')->getNotifications($user_id));
  }

  static public function getUserBadges($user_id) {
    return Doctrine::getTable('Badge')->getUserBadges($user_id);
  }

  static public function getUserBadgeLevels($user_id) {
    return Doctrine::getTable('UserBadge')->getUserBadgeLevels($user_id);
  }

  static public function getBadgeName($level) {
    $badge_names = array('bronze', 'silver', 'gold', 'lime');
    return $badge_names[$level];
  }

  static public function getBadgeClass($level) {
    if ($level == 0)
      return 'first';
    elseif ($level+1 == sfConfig::get('app_badge_num_levels'))
      return 'last';
    else
      return '';
  }

  static public function getUserActionLevels() {
    $levels = array(
      array('names' => array('comment', 'submit news story', 'suggest a limelight', 'edit a limelight stub'), 'min_score' => sfConfig::get('app_mod_1')),
      array('names' => array('add a tag', 'add a link'), 'min_score' => sfConfig::get('app_mod_2')),
      array('names' => array('downvote', 'flag', 'add a NEW tag', 'suggest a website update', 'add a NEW link'), 'min_score' => sfConfig::get('app_mod_3')),
      array('names' => array('add a pro/con', 'add a limelight spec', 'suggest a new category'), 'min_score' => sfConfig::get('app_mod_4')),
      array('names' => array('submit a wiki revision', 'add a limelight slice'), 'min_score' => sfConfig::get('app_mod_5')),
      array('names' => array('add a new wiki segment', 'link a wiki segment'), 'min_score' => sfConfig::get('app_mod_6')),
      array('names' => array('remove tags', 'approve limelights'), 'min_score' => sfConfig::get('app_mod_7'))
    );
    return $levels;
  }

  static public function getUserActionMinScore($action_name) {
    $levels = self::getUserActionLevels();
    foreach ($levels as $level)
      foreach ($level['names'] as $name)
        if ($name == $action_name)
          return $level['min_score'];
  }

  /**
  * fetches and builds the chart data based on the google chart api
  *
  * @param raw_data $raw_data an array of arrays containing chart data. each array much have an 'increase' attribute specifying the daily increase,
   * and a 'date' attribute specifying the date of the increase DATE_FORMAT as '%c-%e' (month-day, without leading 0s)
  * @param item_type $item_type
  */
  static public function executeChart($raw_data, $item_type)
  {
    // create variables to hold the individual data strings which will be later put together into the formatted data variable
    for ($i=0; $i<count($raw_data); $i++)
    {
      $var_name = 'string_'.$i;
      $$var_name = '';
    }

    $formatted_data = ''; // the data strings together in the final form x,x,x|x,x,x|x,x,x,x...
    $x_axis = ''; // holds the x axis data in the form x|x|x|x
    $scale = 10; // the maximum of both score_increase and view_increase, rounded to the nearest 10
    $bottom = 0;
    $stat_pullback = sfConfig::get('app_'.$item_type.'_chart_stat_pullback')/24/60/60; // it is in seconds, need to convert to days

    foreach ($raw_data as $key => $data)
    {
      $var_name = 'string_'.$key;
      for ($i=$stat_pullback-1; $i>=0; $i--)
      {
        $found = false;
        foreach ($data as $dataPoint)
        {
          if ($dataPoint['date'] == date('n-j', time()-(60*60*24*$i)))
          {
            $$var_name .= $dataPoint['increase'];
            $scale = $dataPoint['increase'] > $scale ? $dataPoint['increase'] : $scale;
            $bottom = $dataPoint['increase'] < $bottom ? $dataPoint['increase'] : $bottom;
            $found = true;
            break;
          }
        }

        if (!$found)
          $$var_name .= '0';

        if ($i != 0)
          $$var_name .= ',';
      }

      // put the data together
      $formatted_data .= $$var_name;
      if (isset($raw_data[$key+1]))
        $formatted_data .= '|';
    }

    // round the scale up to the nearest 10
    $scale = ceil($scale/10)*10;

    // round the bottom down to the nearest 5
    $bottom = floor($bottom/5)*5;

    // generate the x-axis string
    for ($i=$stat_pullback-1; $i>=0; $i--)
    {
      $x_axis .= date('n-j', time()-(60*60*24*$i));
      if ($i != 0)
        $x_axis .= '|';
    }

    return array('data' => $formatted_data, 'x_axis' => $x_axis, 'scale' => $scale, 'bottom' => $bottom);
  }

  // get the current chance to win for the beta giveaway area
  static public function getGiveawayChance()
  {
    return Doctrine::getTable('BetaGiveaway')->getChance();
  }
}
?>