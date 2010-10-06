<?php


class SongTable extends ItemTable
{
    
  public static function getInstance()
  {
      return Doctrine_Core::getTable('Song');
  }

  // get the non user specific song information
  public function getSong($name_slug) {
    $q = Doctrine_Query::create()
        ->select('s.*, ll.id')
        ->addSelect('(SELECT SUM(sp.count) FROM SongPlay sp WHERE sp.item_id = s.id AND DATE(sp.created_at) = "'.date('Y-m-d', time()).'") AS daily_views')
        ->from('Song s')
        ->leftJoin('s.Limelights ll WITH ll.status = ?', 'Active')
        ->where('s.name_slug = ?', $name_slug)
        ->useResultCache(true, 120, 'news_'.$name_slug);
    return $q->fetchOne();
  }

  // get the news item information for use in feeds (returns info for a single news feed item)
  public function getForFeed($song_id) {
    $q = Doctrine_Query::create()
        ->select('s.*, ll.id, ll.profile_image, ll.company_name, ll.name, ll.name_slug, l.source_url, c.id, sf.id')
        ->from('Song s')
        ->leftJoin('s.Limelights ll')
        ->leftJoin('s.Comments c WITH c.status = ?', 'Active')
        ->leftJoin('s.SongTags st WITH st.type = ? AND st.status = ?', array('song', 'Active'))
        ->leftJoin('st.Tag t')
        ->leftJoin('s.Favorited sf')
        ->where('s.id = ?', $song_id);
    $result = $q->fetchOne();
    return $result;
  }

  public function getScoreboxInfo($song_id, $user_id) {
    $data = array('pos_amount' => 0, 'neg_amount' => 0, 'scored' => 0);

    $q = Doctrine_Query::create()
        ->select('COUNT(amount) AS pos_amount')
        ->from('SongScore')
        ->where('item_id = ? AND status = ? AND amount > 0', array($song_id, 'Active'));
    $result = $q->fetchOne();
    $data['pos_amount'] = $result['pos_amount'];

    $q = Doctrine_Query::create()
        ->select('COUNT(amount) AS neg_amount')
        ->from('SongScore')
        ->where('item_id = ? AND status = ? AND amount < 0', array($song_id, 'Active'));
    $result = $q->fetchOne();
    $data['neg_amount'] = $result['neg_amount'];

    $data['pos_progress'] = ($data['pos_amount'] + $data['neg_amount'] == 0) ? 5 : ($data['pos_amount'] / ($data['pos_amount'] + $data['neg_amount']))*100;
    $data['neg_progress'] = ($data['pos_amount'] + $data['neg_amount'] == 0) ? 5 : ($data['neg_amount'] / ($data['pos_amount'] + $data['neg_amount']))*100;

    $q = Doctrine_Query::create()
        ->select('amount')
        ->from('SongScore')
        ->where('item_id = ? AND user_id = ?', array($song_id, $user_id));
    $result = $q->fetchOne();
    if ($result['amount'])
    {
      $data['pos_scored'] = $result['amount'] > 0 ? 'on' : '';
      $data['neg_scored'] = $result['amount'] < 0 ? 'on' : '';
    }
    else
    {
      $data['pos_scored'] = 'scorable';
      $data['neg_scored'] = 'scorable';
    }

    return $data;
  }

  public function getFilename($song_id)
  {
    $q = Doctrine_Query::create()
        ->select('filename')
        ->from('Song')
        ->where('id = ?', $song_id)
        ->useResultCache(true, 86000, 'song_filename_'.$song_id);
    return $q->fetchOne();
  }

  public function getByFilters($type, $time_period, $sort_by, $categories, $limit, $offset) {
    $tpTS = time() - (60 * 60 * 24 * $time_period);

    $q = Doctrine_Query::create()
        ->select('s.id')
        ->from('Song s')
        ->where('s.status = ?', array('Active'));

    // What is the user sorting by? News score, user score, or views
    // Join the appropriate table on the appropriate time span
    if ($sort_by == 'popularity') {
      $q->addSelect('(SELECT IF(SUM(ss.amount) IS NULL, 0, SUM(ss.amount)) FROM SongScore ss WHERE ss.item_id = s.id AND ss.status="Active" AND UNIX_TIMESTAMP(ss.created_at) >= '.$tpTS.') AS score_increase');
      $q->addSelect('(SELECT IF(SUM(sp.count) IS NULL, 0, FLOOR(SUM(sp.count)*.1)) FROM SongPlay sp WHERE sp.item_id = s.id AND UNIX_TIMESTAMP(sp.created_at) >= '.$tpTS.') AS plays_increase');
      $q->addSelect('(SELECT IF(COUNT(sf.id) IS NULL, 0, COUNT(sf.id)*3) FROM SongFavorite sf WHERE sf.item_id = s.id AND UNIX_TIMESTAMP(sf.created_at) >= '.$tpTS.') AS favorite_increase');
      $q->orderBy('(score_increase + plays_increase + favorite_increase) DESC');
      $q->addOrderBy('s.created_at DESC');
    }
    else
    {
      $q->orderBy('s.created_at DESC');
    }

    // If we are filtering categories
    if ($categories[0] != 0) {
      $q->leftJoin('s.Limelights ll WITH ll.status = ?', 'Active');
      $q->leftJoin('ll.Categories c WITH c.status = ?', 'Active');
      $q->andWhereIn('c.id', $categories);
    }

    $q->offset($offset);
    $q->limit($limit);

    //$q->useResultCache(true, 60, 'news_feed_'.$c.'_'.$sb.'_'.$ci.'_'.$tp.'_'.$section.'_'.$ll_id);

    return $result = $q->fetchArray();
  }

  // FOR LUCENE SEARCH
  static public function getLuceneIndex()
  {
    ProjectConfiguration::registerZend();

    Zend_Search_Lucene::setResultSetLimit(sfConfig::get('app_song_search_limit'));

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
    return sfConfig::get('sf_data_dir').'/song.'.sfConfig::get('sf_environment').'.index';
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
        ->select('id, name, name_slug, content, filename, created_at')
        ->from('Song')
        ->whereIn('id', $pks)
        ->limit(sfConfig::get('app_song_search_limit'));

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
}