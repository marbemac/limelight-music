<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class NewsTable extends ItemTable
{
  // get the non user specific news item information
  public function getNewsItem($title_slug) {
    $q = Doctrine_Query::create()
        ->select('n.*, ll.id')
        ->addSelect('(SELECT SUM(nv.count) FROM NewsView nv WHERE nv.item_id = n.id AND DATE(nv.created_at) = "'.date('Y-m-d', time()).'") AS daily_views')
        ->from('News n')
        ->leftJoin('n.Limelights ll WITH ll.status = ?', 'Active')
        ->where('n.title_slug = ?', $title_slug)
        ->useResultCache(true, 120, 'news_'.$title_slug);
    return $q->fetchOne();
  }

  // get the news item information for use in feeds (returns info for a single news feed item)
  public function getForFeed($news_id) {
    $q = Doctrine_Query::create()
        ->select('n.*, ll.id, ll.profile_image, ll.company_name, ll.name, ll.name_slug, l.source_url, s.name, c.id, nf.id')
        ->from('News n')
        ->leftJoin('n.Limelights ll')
        ->leftJoin('n.Links l WITH l.status = ?', 'Active')
        ->leftJoin('l.Source s')
        ->leftJoin('n.Comments c WITH c.status = ?', 'Active')
        ->leftJoin('n.Tags nt WITH status = ?', 'Active')
        ->leftJoin('nt.Tag t')
        ->leftJoin('n.Favorited nf')
        ->where('n.id = ?', $news_id);
    $results = $q->fetchArray();
    return $results[0];
  }

  public function getByFilters($type, $time_period, $sort_by, $categories, $limit, $offset) {
    $tpTS = time() - (60 * 60 * 24 * $time_period);

    $q = Doctrine_Query::create()
        ->select('n.id')
        ->from('News n')
        ->where('n.status = ?', array('Active'));

    // What is the user sorting by? News score, user score, or views
    // Join the appropriate table on the appropriate time span
    if ($sort_by == 'popularity') {
      $q->addSelect('(SELECT IF(SUM(ns.amount) IS NULL, 0, SUM(ns.amount)) FROM NewsScore ns WHERE ns.item_id = n.id AND ns.status="Active" AND UNIX_TIMESTAMP(ns.created_at) >= '.$tpTS.') AS score_increase');
      $q->addSelect('(SELECT IF(SUM(nv.count) IS NULL, 0, FLOOR(SUM(nv.count)*.1)) FROM NewsView nv WHERE nv.item_id = n.id AND UNIX_TIMESTAMP(nv.created_at) >= '.$tpTS.') AS views_increase');
      $q->addSelect('(SELECT IF(COUNT(nf.id) IS NULL, 0, COUNT(nf.id)*3) FROM NewsFavorite nf WHERE nf.item_id = n.id AND UNIX_TIMESTAMP(nf.created_at) >= '.$tpTS.') AS favorite_increase');
      $q->orderBy('(score_increase + views_increase + favorite_increase) DESC');
      $q->addOrderBy('n.created_at DESC');
    }
    else
    {
      $q->orderBy('n.created_at DESC');
    }

    // If we are filtering categories
    if ($categories[0] != 0) {
      $q->leftJoin('n.Limelights ll WITH ll.status = ?', 'Active');
      $q->leftJoin('ll.Categories c WITH c.status = ?', 'Active');
      $q->andWhereIn('c.id', $categories);
    }

    $q->offset($offset);
    $q->limit($limit);

    //$q->useResultCache(true, 60, 'news_feed_'.$c.'_'.$sb.'_'.$ci.'_'.$tp.'_'.$section.'_'.$ll_id);
    
    return $result = $q->fetchArray();
  }

  public function getTags($news_title_slug, $user_id)
  {
    $q = Doctrine_Query::create()
        ->select('n.id, nt.*, nts.user_id AS scored')
        ->from('News n')
        ->leftJoin('n.Tags nt WITH nt.status = ?', 'Active')
        ->leftJoin('nt.Scores nts WITH nts.user_id = ?', $user_id)
        ->where('n.title_slug = ?', $news_title_slug)
        ->orderBy('nt.score DESC');

    $result = $q->fetchArray();
    return $result;
  }

  public function increaseFieldValue($title_slug, $field_name, $increase)
  {
    $q = Doctrine_Query::create()
    ->update('News')
    ->set($field_name, $field_name + 1)
    ->where('title_slug = ?', $title_slug);
    $q->execute();
  }

  // Used on the rankings page
  public function getTopNews($days)
  {
    $q = Doctrine_Query::create()
        ->select('n.id, n.title, n.score, n.total_views, n.comment_count, n.favorited_count, n.title_slug, SUM(s.count) AS news_score_increase')
        ->from('News n')
        ->leftJoin('n.NewsScores s WITH UNIX_TIMESTAMP(s.created_at) >= ?', time() - (60 * 60 * 24 * $days))
        ->groupBy('n.id')
        ->orderBy('news_score_increase DESC')
        ->limit(sfConfig::get('app_rankings_news_max'));

    return $q->fetchArray();
  }

  // FOR LUCENE SEARCH
  static public function getLuceneIndex()
  {
    ProjectConfiguration::registerZend();

    Zend_Search_Lucene::setResultSetLimit(sfConfig::get('app_news_search_limit'));

    if (file_exists($index = self::getLuceneIndexFile()))
    {
      return Zend_Search_Lucene::open($index);
    }
    else
    {
      return Zend_Search_Lucene::create($index);
    }
  }

  static public function getLuceneIndexFile()
  {
    return sfConfig::get('sf_data_dir').'/news.'.sfConfig::get('sf_environment').'.index';
  }

  public function getForLuceneQuery($query, $type=null)
  {
    $hits = $this->getLuceneIndex()->find($query);

    $pks = array();
    foreach ($hits as $hit)
    {
      $pks[] = $hit->pk;
    }

    if (empty($pks))
    {
      return array();
    }

    $q = Doctrine_Query::create()
        ->select('id, title, title_slug, content, created_at')
        ->from('News')
        ->whereIn('id', $pks)
        ->limit(sfConfig::get('app_news_search_limit'));
    
    $items = $q->execute();

    // sort according to order of PKs generated by lucene (the PKs are sorted by lucene rank)
    $results = array();
    foreach ($pks as $pk)
    {
      foreach ($items as $item)
      {
        if ($item['id'] == $pk)
          $results[] = $item;
      }
    }

    return $results;
  }

  
  public function getForNewsLookup($url)
  {
    $results = array('info' => array(), 'images' => array(), 'stories' => array(), 'tags' => array(), 'limelights' => array());

    if(filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED) === FALSE)
    {
        return array('result' => 'error');
    }
    /*** get the url parts ***/
    $parts = parse_url($url);
    /*** return the host domain ***/
    $parts = explode('.', $parts['host']);
    $results['info']['source'] = ucwords(preg_replace('/the/', 'the ', $parts[count($parts)-2]));

    // scrape the data
    // Scrape google for the first 10 images that match the name
    require(sfConfig::get('sf_root_dir').'/lib/Goutte/goutte.phar');
    $client = new Goutte\Client();

    $crawler = $client->request('GET', $url);
    $title = $crawler->filter('head title')->text();
    $results['info']['title'] = trim(trim(str_ireplace($results['info']['source'], ' ', $title)), ' |-,');

    $meta = $crawler->filter('meta[name="description"]');
    if ($meta->count())
    {
      $results['info']['content'] = trim(trim($meta->attr('content')), ' |-,');
    }

    $hits = $this->getLuceneIndex()->find($results['info']['title']);

    $pks = array();
    foreach ($hits as $hit)
    {
      if ($hit->score >= .1)
        $pks[] = $hit->pk;
    }

    if (empty($pks))
    {
      return $results;
    }

    // find the news stories
    $q = Doctrine_Query::create()
        ->select('id, title, title_slug, content, created_at')
        ->from('News')
        ->where('UNIX_TIMESTAMP(created_at) >= ?', time()-(60*60*24*45))
        ->whereIn('id', $pks)
        ->limit(sfConfig::get('app_news_search_limit'));

    $items = $q->execute();

    if (count($items) == 0)
    {
      return $results;
    }

    // sort according to order of PKs generated by lucene (the PKs are sorted by lucene rank)
    $used_items = array();
    foreach ($pks as $pk)
    {
      foreach ($items as $item)
      {
        if ($item['id'] == $pk)
        {
          $used_items[] = $pk;
          $results['stories'][] = array('id' => $item['id'], 'title' => $item['title'], 'content' => $item['content'], 'url' => url_for('news_show', array('title_slug' => $item['title_slug'])), 'date' => 'submitted '.LimelightUtils::timeLapse($item['created_at']));
        }
      }
    }

    // find the news tags
    $q = Doctrine_Query::create()
        ->select('nt.id, nt.tag_id, (SUM(nt.score)+COUNT(DISTINCT nt.id)) AS score, t.name AS name')
        ->from('NewsTag nt')
        ->innerJoin('nt.Tag t')
        ->where('nt.status = ?', 'Active')
        ->whereIn('nt.item_id', $used_items)
        ->groupBy('t.name')
        ->limit(sfConfig::get('app_news_search_limit'));

    $items = $q->execute();

    // shitty bubble sort
    for($x = 0; $x < count($items); $x++) {
      for($y = 0; $y < count($items); $y++) {
        if($items[$x]['score'] > $items[$y]['score']) {
          $hold = $items[$x];
          $items[$x] = $items[$y];
          $items[$y] = $hold;
        }
      }
    }
    foreach ($items as $item)
    {
      $results['tags'][] = array('tag_id' => $item['tag_id'], 'name' => $item['name']);
    }

    // find the limelights
    $q = Doctrine_Query::create()
        ->select('ln.news_id, ll.id id, ll.name name, ll.score score, ll.profile_image profile_image')
        ->from('LimelightNews ln')
        ->innerJoin('ln.Limelight ll')
        ->where('ll.status = ?', 'Active')
        ->whereIn('ln.news_id', $used_items)
        ->groupBy('ll.name')
        ->limit(sfConfig::get('app_news_search_limit'));

    $items = $q->execute();

    // shitty bubble sort
    for($x = 0; $x < count($items); $x++) {
      for($y = 0; $y < count($items); $y++) {
        if($items[$x]['score'] > $items[$y]['score']) {
          $hold = $items[$x];
          $items[$x] = $items[$y];
          $items[$y] = $hold;
        }
      }
    }
    foreach ($items as $item)
    {
      $results['limelights'][] = array('id' => $item['id'], 'name' => $item['name'], 'score' => $item['score'], 'profile_image' => sfConfig::get('app_limelight_image_path').'/thumb/'.$item['profile_image']);
    }

    return $results;
  }
  // END LUCENE SEARCH
}