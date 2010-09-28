<?php

class LimelightTable extends ItemTable
{
  public function getLimelightsByCategory($category_id)
  {
    $q = Doctrine_Query::create()
        ->select('l.*')
        ->from('Limelight l')
        ->leftJoin('l.CategoryLimelight cl on l.id = cl.limelight_id')
        ->where('cl.category_id = ?', $category_id)
        ->orderBy('created_at DESC');
    $result = $q->fetchArray();

    return $result;
  }

  public function getCategories($ll_id)
  {
    $q = Doctrine_Query::create()
        ->select('ll.id, c.id, c.name, c.parent_id, c.amazon_category')
        ->from('Limelight ll')
        ->leftJoin('ll.Categories c')
        ->where('ll.id = ?', $ll_id)
        ->orderBy('c.name ASC');
    $result = $q->fetchOne();

    return $result;
  }

  // check if the specifications area should actually be requirements
  public function checkSpecRequirements($ll_id)
  {
    $q = Doctrine_Query::create()
        ->select('ll.id, c.name')
        ->from('Limelight ll')
        ->leftJoin('ll.Categories c')
        ->where('ll.id = ? AND c.parent_id IS NULL AND c.name_slug != ? AND c.name_slug != ?', array($ll_id, 'video-games', 'software'))
        ->useResultCache(true, 300, 'limelight_specrequirements_check_'.$ll_id);
    $result = $q->fetchOne();

    if (count($result['Categories']) > 0)
      return 'specification';
    else
      return 'requirement';
  }

  public function getNewsfeed($ll_id, $limelight_type, $limit, $offset) {
    if ($limelight_type == 'source')
    {
      $q = Doctrine_Query::create()
          ->select('n.id')
          ->from('News n')
          ->innerJoin('n.Links l')
          ->where('n.status = ? AND l.source_id = ?', array('Active', $ll_id))
          ->orderBy('n.created_at DESC')
          ->limit($limit)
          ->offset($offset);
    }
    else
    {
      $q = Doctrine_Query::create()
          ->select('n.id')
          ->from('News n')
          ->innerJoin('n.NewsLimelights nl')
          ->where('n.status = ? AND nl.limelight_id = ?', array('Active', $ll_id))
          ->orderBy('n.created_at DESC')
          ->limit($limit)
          ->offset($offset);
    }

    $q->useResultCache(true, 60, 'limelight_feed_news_'.$ll_id.'_'.$limit.'_'.$offset);
    $results = $q->fetchArray();
    return $results;
  }

  public function getSpecifications($ll_id, $user_id)
  {
    $q = Doctrine_Query::create()
        ->select('lls.*, sp.name AS name, s.name')
        ->from('LimelightSpecification lls')
        ->leftJoin('lls.Specification sp')
        ->leftJoin('lls.Source s')
        ->where('lls.item_id = ? AND lls.status = ?', array($ll_id, 'Active'))
        ->orderBy('sp.name ASC')
        ->useResultCache(true, 3600, 'limelight_specifications_'.$ll_id);
    $result = $q->fetchArray();

    $specs = array();
    foreach ($result as $key => $spec)
    {
      $id = $spec['slice_id'] ? $spec['slice_id'] : 0;
      $specs[$id][] = $spec;
    }

    return $specs;
  }

  public function populateSources()
    {
      $q = Doctrine_Query::create()
          ->select('name')
          ->from('Limelight')
          ->where('status = ? AND limelight_type = ?', array('Active', 'Source'))
          ->useResultCache(true, 86400, 'sources');
      return $q->execute(array(), Doctrine::HYDRATE_NONE);
    }

  public function checkStub($ll_id)
  {
    $q = Doctrine_Query::create()
        ->select('id, is_stub')
        ->from('Limelight')
        ->where('id = ?', $ll_id)
        ->useResultCache(true, 120, 'limelight_stub_check_'.$ll_id);
    return $q->fetchOne();
  }

  public function getStubStats($ll_id)
  {
    $q = Doctrine_Query::create()
        ->select('ll.id, ll.name AS name, COUNT(DISTINCT n.id) AS news_count, COUNT(DISTINCT ls.id) AS specification_count, COUNT(DISTINCT llpc.id) AS procon_count')
        ->from('Limelight ll')
        ->leftJoin('ll.Newss n WITH n.status = ?', 'Active')
        ->leftJoin('ll.Specifications ls WITH ls.status = ?', 'Active')
        ->leftJoin('ll.LimelightProCons llpc WITH llpc.status = ?', 'Active')
        ->where('ll.id = ?', $ll_id)
        ->useResultCache(true, 120, 'limelight_stub_stats_'.$ll_id);
    $result = $q->fetchOne();

    $q = Doctrine_Query::create()
        ->select('topics, content')
        ->from('Wiki')
        ->where('topics = ? AND is_active = ?', array($result['name'], 1))
        ->useResultCache(true, 120, 'limelight_stub_stats_wiki_'.$ll_id);
    $wiki_result = $q->fetchOne();

    $stubText = array('News' => array(
                                'neg' => 'there are no news stories connected to this limelight',
                                'mid' => 'there are some news stories connected to this limelight - getting there!',
                                'pos' => 'there are a bunch of news stories conntected to this limelight'),
                      'Wiki' => array(
                                'neg' => 'the '.$result['name'].' wiki segment for this limelight is almost non-existent',
                                'mid' => 'the '.$result['name'].' wiki for this limelight is decent, but not quite there yet',
                                'pos' => 'the '.$result['name'].' wiki for this limelight is in good shape'),
                      'LimelightSpecification' => array(
                                'neg' => 'there are no specifications for this limelight',
                                'mid' => 'there are some specifications, but not enough',
                                'pos' => 'there are a good amount of specificaitons for this limelight'),
                      'LimelightProCon' => array(
                                'neg' => 'there are no pros or cons for this limelight',
                                'mid' => 'there are some pros and/or cons for this limelight',
                                'pos' => 'there are a good amount of pros and/or cons for this limelight')
                      );

    $return_data = array();
    $return_data['Overall'] = 0;

    if ($result['news_count'] == 0)
    {
      $return_data['News'] = array('content' => $stubText['News']['neg'], 'status' => 'neg');
      $return_data['Overall'] += 0;
    }
    else if ($result['news_count'] <= 2)
    {
      $return_data['News'] = array('content' => $stubText['News']['mid'], 'status' => 'mid');
      $return_data['Overall'] += 15;
    }
    else
    {
      $return_data['News'] = array('content' => $stubText['News']['pos'], 'status' => 'pos');
      $return_data['Overall'] += 30;
    }

    if (strlen($wiki_result['content']) <= 200)
    {
      $return_data['Wiki'] = array('content' => $stubText['Wiki']['neg'], 'status' => 'neg');
      $return_data['Overall'] += 0;
    }
    else if (strlen($wiki_result['content']) <= 500)
    {
      $return_data['Wiki'] = array('content' => $stubText['Wiki']['mid'], 'status' => 'mid');
      $return_data['Overall'] += 15;
    }
    else
    {
      $return_data['Wiki'] = array('content' => $stubText['Wiki']['pos'], 'status' => 'pos');
      $return_data['Overall'] += 30;
    }

    if ($result['specification_count'] == 0)
    {
      $return_data['LimelightSpecification'] = array('content' => $stubText['LimelightSpecification']['neg'], 'status' => 'neg');
      $return_data['Overall'] += 0;
    }
    else if ($result['specification_count'] <= 5)
    {
      $return_data['LimelightSpecification'] = array('content' => $stubText['LimelightSpecification']['mid'], 'status' => 'mid');
      $return_data['Overall'] += 10;
    }
    else
    {
      $return_data['LimelightSpecification'] = array('content' => $stubText['LimelightSpecification']['pos'], 'status' => 'pos');
      $return_data['Overall'] += 20;
    }

    if ($result['procon_count'] == 0)
    {
      $return_data['LimelightProCon'] = array('content' => $stubText['LimelightProCon']['neg'], 'status' => 'neg');
      $return_data['Overall'] += 0;
    }
    else if ($result['procon_count'] <= 6)
    {
      $return_data['LimelightProCon'] = array('content' => $stubText['LimelightProCon']['mid'], 'status' => 'mid');
      $return_data['Overall'] += 10;
    }
    else
    {
      $return_data['LimelightProCon'] = array('content' => $stubText['LimelightProCon']['pos'], 'status' => 'pos');
      $return_data['Overall'] += 20;
    }

    return $return_data;
  }

  public function getFollowingFeed($user_id, $limit, $offset, $following) {
    $types = array('News');

    if (count($following) == 0)
      return array();

    $following_ids = array();
    foreach ($following as $key => $limelight)
      $following_ids[$key] = $limelight['limelight_id'];
    sort($following_ids, SORT_NUMERIC);

    $q = Doctrine_Query::create()
        ->select('n.id, ll.id, ll.status')
        ->from('News n')
        ->innerJoin('n.Limelights ll')
        ->andWhereIn('ll.id', $following_ids)
        ->orderBy('n.created_at DESC')
        ->limit($limit)
        ->offset($offset)
        ->groupBy('n.id');
    $q->useResultCache(true, 300, 'user_'.$user_id.'_following_limelight_feed_'.$limit.'_'.$offset);
    $results = $q->fetchArray();

    $items= $results;
    foreach ($results as $news)
    {
      $items[] = array('type' => 'News', 'News_id' => $news['id']);
    }

    return $items;
  }

  public function getByFilters($type, $time_period, $sort_by, $categories, $limit, $offset) {
    $tpTS = time() - (60 * 60 * 24 * $time_period);

    $q = Doctrine_Query::create()
        ->select('ll.id')
        ->from('Limelight ll')
        ->where('ll.status = ?', array('Active'));

    // What is the user sorting by? News score, user score, or views
    // Join the appropriate table on the appropriate time span
    if ($sort_by == 'popularity') {
      $q->addSelect('(SELECT IF(SUM(s.amount) IS NULL, 0, SUM(s.amount)) FROM LimelightScore s WHERE s.item_id = ll.id AND s.status="Active" AND UNIX_TIMESTAMP(s.created_at) >= '.$tpTS.') AS score_increase');
      $q->addSelect('(SELECT IF(SUM(v.count) IS NULL, 0, FLOOR(SUM(v.count)*.1)) FROM LimelightView v WHERE v.item_id = ll.id AND UNIX_TIMESTAMP(v.created_at) >= '.$tpTS.') AS views_increase');
      $q->addSelect('(SELECT IF(COUNT(f.id) IS NULL, 0, COUNT(f.id)*3) FROM LimelightFavorite f WHERE f.item_id = ll.id AND UNIX_TIMESTAMP(f.created_at) >= '.$tpTS.') AS favorite_increase');
      $q->orderBy('(score_increase + views_increase + favorite_increase) DESC');
      $q->addOrderBy('ll.created_at DESC');
    }
    else
    {
      $q->orderBy('ll.created_at DESC');
    }

    // If we are filtering categories
    if ($categories[0] != 0) {
      $q->leftJoin('ll.Categories c WITH c.status = ?', 'Active');
      $q->andWhereIn('c.id', $categories);
    }

    $q->offset($offset);
    $q->limit($limit);

    //$q->useResultCache(true, 60, 'news_feed_'.$c.'_'.$sb.'_'.$ci.'_'.$tp.'_'.$section.'_'.$ll_id);

    return $result = $q->fetchArray();
  }

  // get the limelight item information for use in feeds
  public function getForFeed($ll_id) {
    $q = Doctrine_Query::create()
        ->select('ll.id, ll.name, ll.score, ll.user_id, ll.total_views, ll.profile_image, ll.name_slug, ll.created_at, ll.user_id, 
                  s.summary, n.id, n.title, n.title_slug, n.created_at, n.content, n.user_id, lfol.id, lfav.id')
        ->from('Limelight ll')
        ->innerJoin('ll.Summaries s WITH s.is_active = ? ', true)
        ->leftJoin('ll.Newss n WITH n.status = ?', 'Active')
        ->leftJoin('ll.Followers lfol')
        ->leftJoin('ll.Favorited lfav')
        ->orderBy('n.created_at DESC')
        ->where('ll.id = ?', $ll_id);
    return $q->fetchOne();
  }

  public function approveLimelight($ll_id)
  {
    $ll = $this->find($ll_id);
    if ($ll)
    {
      $ll->is_stub = 0;
      $ll->save();
      Doctrine::getTable('Badge')->increaseBadgeStat('Foresight', $ll->user_id);
    }
  }

  public function increaseFieldValue($name_slug, $field_name, $increase)
  {
    Doctrine_Query::create()
    ->update('Limelight')
    ->set($field_name, $field_name + 1)
    ->where('name_slug = ?', $name_slug)
    ->execute();
  }

  public function getLimelightStats($ll_id, $user_id)
  {
    $q = Doctrine_Query::create()
        ->select('l.id, l.is_stub, ls.summary, ls.version, COUNT(DISTINCT n.id) AS new_news_count, COUNT(DISTINCT r.id) AS new_reviews_count')
        ->from('Limelight l')
        ->innerJoin('l.Summaries ls WITH ls.is_active = ?', true)
        ->leftJoin('l.Newss n WITH n.status = ? AND UNIX_TIMESTAMP(n.created_at) > ?', array('Active', time() - sfConfig::get('app_limelight_head_stat_pullback')))
        ->leftJoin('l.UserReviews r WITH r.status = ? AND UNIX_TIMESTAMP(r.created_at) > ?', array('Active', time() - sfConfig::get('app_limelight_head_stat_pullback')))
        ->where('l.id = ?', $ll_id)
        ->useResultCache(true, 120, 'limelight_stats_'.$ll_id);;
    $result = $q->fetchOne();

    return $result;
  }

  // *******************
  // gets chart data for the limelight component 'chart', used for charts in limelight heads
  // *******************
  public function getLimelightNewsChartData($ll_id)
  {
    $q = Doctrine_Query::create()
        ->select('ll.id, COUNT(DISTINCT n.id) AS increase, DATE_FORMAT(n.created_at, "%c-%e") AS date')
        ->from('Limelight ll')
        ->leftJoin('ll.Newss n WITH UNIX_TIMESTAMP(n.created_at) > ? AND n.status = ?', array(time() - sfConfig::get('app_limelight_chart_stat_pullback'), 'Active'))
        ->where('ll.id = ?', $ll_id)
        ->groupBy('DATE_FORMAT(n.created_at, "%d/%m/%Y")');
    $result = $q->fetchArray();

    return $result;
  }

//  public function getLimelightReviewChartData($ll_id)
//  {
//    $q = Doctrine_Query::create()
//        ->select('SUM(lv.count) AS increase, DATE_FORMAT(lv.created_at, "%c-%e") AS date')
//        ->from('LimelightView lv')
//        ->where('lv.limelight_id = ? AND UNIX_TIMESTAMP(lv.created_at) > ?', array($ll_id, time() - sfConfig::get('app_limelight_chart_stat_pullback')))
//        ->groupBy('DATE_FORMAT(lv.created_at, "%d/%m/%Y")')
//        ->orderBy('date DESC')
//        ->limit(sfConfig::get('app_limelight_chart_stat_pullback'));
//    //$q->useResultCache(true, 1800, 'limelight_chartdata_scores_'.$ll_id);
//    $result = $q->fetchArray();
//
//    return $result;
//  }
//
//  public function getLimelightWikiChartData($ll_id)
//  {
//    $q = Doctrine_Query::create()
//        ->select('SUM(lv.count) AS increase, DATE_FORMAT(lv.created_at, "%c-%e") AS date')
//        ->from('LimelightView lv')
//        ->where('lv.limelight_id = ? AND UNIX_TIMESTAMP(lv.created_at) > ?', array($ll_id, time() - sfConfig::get('app_limelight_chart_stat_pullback')))
//        ->groupBy('DATE_FORMAT(lv.created_at, "%d/%m/%Y")')
//        ->orderBy('date DESC')
//        ->limit(sfConfig::get('app_limelight_chart_stat_pullback'));
//    //$q->useResultCache(true, 1800, 'limelight_chartdata_scores_'.$ll_id);
//    $result = $q->fetchArray();
//
//    return $result;
//  }
  // *********************

  public function getSidebarInfo($name_slug)
  {
    $q = Doctrine_Query::create()
        ->select('l.id, l.total_views AS total_views, SUM(lv.count) AS daily_views')
        ->from('Limelight l')
        ->leftJoin('l.Views lv WITH DATE(lv.created_at) = ?', date('Y-m-d', time()))
        ->where('l.name_slug = ?', $name_slug);
    $result = $q->fetchOne();

    return $result;
  }

  // used on limelight pages to get the slices
  public function getSlices($ll_id, $ll_name, $for_form = null)
  {
    $q = Doctrine_Query::create()
        ->select('id, name')
        ->from('LimelightSlice')
        ->where('item_id = ?', $ll_id);
    $q->useResultCache(true, 300, 'limelight_slices_'.$ll_id);
    $results = $q->fetchArray();

    if ($for_form)
    {
      $slices = array(0 => 'General '.$ll_name);
      foreach ($results as $slice)
      {
        $slices[$slice['id']] = $ll_name.' '.$slice['name'];
      }
      return $slices;
    }

    return $results;
  }

  public function getTopLimelights($limit, $days) {
    $curTime = time();
    if ($days != 0)
      $past = $curTime - (60 * 60 * 24 * $days);
    else
      $past = 0;

    $q = Doctrine_Query::create()
      ->select('ll.id, ll.score')
      ->addSelect('(SELECT sum(lls.amount) FROM LimelightScore lls WHERE UNIX_TIMESTAMP(lls.created_at) >= '.$past.' AND ll.id = lls.item_id AND lls.status = "Active") AS score_increase')
      ->from('Limelight ll')
      ->where('ll.status = ?', array('Active'))
      ->limit($limit)
      ->orderBy('score_increase DESC');
    $q->useResultCache(true, 60, 'toplimelights_'.$days);
    return $q->fetchArray();
  }

  // Returns the score types for the category the limelight belongs to
  // also returns the averages for those score types in the category
  public function getLimelightUserReviewInfo($ll_id)
  {
    $q = Doctrine_Query::create()
        ->select('l.id, l.name, c.id, c.name, cst.*, sp.category_score_type_id, AVG(sp.score) as average_score')
        ->from('Limelight l')
        ->leftJoin('l.Categories c')
        ->leftJoin('c.CategoryScoreType cst')
        ->leftJoin('cst.LimelightReviewScoreParts sp')
        ->groupBy('cst.id')
        ->where('l.id = ?', $ll_id);

    return $q->fetchArray();
  }
  // returns an array containing the averages for all the score parts in a limelight
  public function getLimelightScorePartsAverage($ll_id)
  {
    $q = Doctrine_Query::create()
        ->select('l.id, ru.id, sp.id, AVG(sp.score) as average_score')
        ->from('Limelight l')
        ->leftJoin('l.LimelightReviewUser ru')
        ->leftJoin('ru.LimelightReviewScoreParts sp')
        ->groupBy('sp.category_score_type_id')
        ->where('l.id = ?', $ll_id);

    return $q->fetchArray();
  }

  public function populateBasicSearch() {
    $q = Doctrine_Query::create()
        ->select('id, name, score, profile_image, company_name, name_slug')
        ->from('Limelight l')
        ->where('status = ?', 'Active');

    return $q->execute(array(), Doctrine::HYDRATE_NONE);
  }

  public function getLimelight($ll_id)
  {
    $q = Doctrine_Query::create()
        ->select('id, name, name_slug, score, company_name, company_id, limelight_type, profile_image')
        ->from('Limelight l')
        ->where('l.id = ?', $ll_id);
    $q->useResultCache(true, 3600, 'limelight_'.$ll_id);
    return $q->fetchOne();
  }

  // POSSIBLY DEPRECATED, was only used in limelightLink
  public function findOneWithCategories($ll_id) {
    $q = Doctrine_Query::create()
        ->select('l.id, l.name, l.name_slug, l.score, l.company_name, l.profile_image, l.name, c.name, c.name_slug')
        ->from('Limelight l')
        ->leftJoin('l.Categories c WITH c.status = ?', 'Active')
        ->where('l.id = ?', $ll_id);
    $q->useResultCache(true, 120, 'limelight_link_'.$ll_id);
    return $q->fetchOne();
  }

  // given a user_id, news id, add an array of limelights (names given)
  // add the limelights if they arent already in the DB, and connect them
  // to the news story
  public function newsAddLimelights($user_id, $news_id, $limelights)
  {
    $limelights_slug = array();
    foreach ($limelights as $limelight)
      $limelights_slug[] = LimelightUtils::slugify ($limelight);

    $q = Doctrine_Query::create()
        ->select('id, name_slug')
        ->from('Limelight')
        ->whereIn('name_slug', $limelights_slug);
    $results = $q->execute();

    foreach ($limelights_slug as $key => $limelight)
    {
      $found = false;
      
      if (count($results) > 0)
      {
        foreach ($results as $key2 => $result)
        {
          if ($limelight == $result['name_slug'])
          {
            $limelight_id = $result['id'];
            $found = true;
          }
        }
      }
      
      // create the limelight if it hasn't been added before
      if (!$found)
      {
          $l = new Limelight();
          $l->name = substr($limelights[$key], 0, sfConfig::get('app_limelight_name_max_length'));
          $l->user_id = $user_id;
          $l->save();
          $limelight_id = $l->id;
      }

      // check that it is not already linked
      $q = Doctrine_Query::create()
        ->select('id')
        ->from('LimelightNews')
        ->where('limelight_id = ? AND news_id = ?', array($limelight_id, $news_id));
      $link = $q->fetchOne();

      if (!$link)
      {
        // link the news story
        $ln = new limelightNews();
        $ln->limelight_id = $limelight_id;
        $ln->news_id = $news_id;
        $ln->save();
      }
    }
  }

  // given a user_id, song id, add an array of limelights (names given)
  // add the limelights if they arent already in the DB, and connect them
  // to the song
  public function songAddLimelights($user_id, $song_id, $limelights)
  {
    $limelights_slug = array();
    foreach ($limelights as $limelight)
      $limelights_slug[] = LimelightUtils::slugify ($limelight);

    $q = Doctrine_Query::create()
        ->select('id, name_slug')
        ->from('Limelight')
        ->whereIn('name_slug', $limelights_slug);
    $results = $q->execute();

    foreach ($limelights_slug as $key => $limelight)
    {
      $found = false;

      if (count($results) > 0)
      {
        foreach ($results as $key2 => $result)
        {
          if ($limelight == $result['name_slug'])
          {
            $limelight_id = $result['id'];
            $found = true;
          }
        }
      }

      // create the limelight if it hasn't been added before
      if (!$found)
      {
          $l = new Limelight();
          $l->name = substr($limelights[$key], 0, sfConfig::get('app_limelight_name_max_length'));
          $l->user_id = $user_id;
          $l->limelight_type = 'artist';
          $l->save();
          $limelight_id = $l->id;
      }

      // check that it is not already linked
      $q = Doctrine_Query::create()
        ->select('id')
        ->from('LimelightSong')
        ->where('limelight_id = ? AND song_id = ?', array($limelight_id, $song_id));
      $link = $q->fetchOne();

      if (!$link)
      {
        // link the news story
        $ls = new LimelightSong();
        $ls->limelight_id = $limelight_id;
        $ls->song_id = $song_id;
        $ls->save();
      }
    }
  }

  // checks for limelight matches on a given name, and returns an array
  // of possible limelight links
  public function checkExistence($name)
  {
    $name_slug = LimelightUtils::slugify($name);
    $q = Doctrine_Query::create()
        ->select('id, name_slug, name, company_name')
        ->from('Limelight')
        ->where('name_slug LIKE ?', '%'.$name_slug.'%')
        ->limit(20);
    $results = $q->execute();

    return $results;
  }

  // create an array of company names and return them
  public function populateCompanies()
  {
    $q = Doctrine_Query::create()
        ->select('name')
        ->from('Limelight')
        ->where('status = ? AND limelight_type = ?', array('Active', 'company'));
    $results = $q->execute(array(), Doctrine::HYDRATE_NONE);

    return $results;
  }

  public function getProducts($ll_id, $limit, $offset)
  {
    $q = Doctrine_Query::create()
        ->select('id, score')
        ->from('Limelight')
        ->where('company_id = ? AND status = ?', array($ll_id, 'Active'))
        ->offset($offset)
        ->limit($limit)
        ->orderBy('score DESC')
        ->useResultCache(true, 300, 'limelight_products_'.$ll_id.'_'.$offset.'_'.$limit);

    return $q->fetchArray();
  }
}