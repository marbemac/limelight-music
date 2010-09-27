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
        ->select('n.*, ll.id')
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
        ->leftJoin('s.Tags st WITH status = ?', 'Active')
        ->leftJoin('st.Tag t')
        ->leftJoin('s.Favorited sf')
        ->where('s.id = ?', $song_id);
    $results = $q->fetchArray();
    return $results[0];
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
}