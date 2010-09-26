<?php


class WikiTable extends ItemTable
{
  public static function getInstance()
  {
      return Doctrine_Core::getTable('Wiki');
  }

  public function getLimelightWikis($limelight_id)
  {
    $q = Doctrine_Query::create()
      ->select('ll.id, lw.id, w.*, lw2.id, ll2.id')
      ->from('Limelight ll')
      ->leftJoin('ll.LimelightWikis lw')
      ->leftJoin('lw.Wiki w WITH w.is_active = ?', true)
      ->leftJoin('w.LimelightWikis lw2')
      ->leftJoin('lw2.Limelight ll2 WITH ll2.status = ?', 'Active')
      ->where('ll.id = ?', $limelight_id)
      ->orderBy('lw.order_id ASC');
    $result = $q->fetchArray();

    return $result[0]['LimelightWikis'];
  }

  // returns a wiki object if the user identified by user_id is currently
  // editing a wiki segment
  public function isEditing($user_id)
  {
    $q = Doctrine_Query::create()
      ->select('w.id, w.edit_lock, w.edit_lock_user_id')
      ->from('Wiki w')
      ->where('w.edit_lock = ? AND w.edit_lock_user_id = ?', array(1, $user_id));
    $result = $q->fetchOne();

    return $result;
  }

  // get the max version for a wiki group
  public function getMaxVersion($group_id)
  {
    $q = Doctrine_Query::create()
        ->select('version')
        ->from('Wiki')
        ->where('group_id = ?', $group_id)
        ->orderBy('version DESC');
    $result = $q->fetchOne();
    return $result['version'];
  }

  // input is an array of LimelightWiki ids, in the new sorted order
  public function resort($order)
  {
    $q = Doctrine_Query::create()
        ->select('id, order_id')
        ->from('LimelightWiki')
        ->whereIn('id', $order)
        ->orderBy('order_id ASC');
    $result = $q->fetchArray();

    foreach($result as $key => $limelight_wiki)
    {
      if ($limelight_wiki['id'] != $order[$key])
      {
        Doctrine_Query::create()
        ->update('LimelightWiki')
        ->set('order_id', $key+1)
        ->where('id = ?', $order[$key])
        ->execute();
      }
    }
  }

  // find and return the next available group_id number
  public function generateGroupId()
  {
    $q = Doctrine_Query::create()
        ->select('id, group_id')
        ->from('Wiki')
        ->orderBy('group_id DESC');
    $result = $q->fetchOne();
    return $result['group_id'] + 1;
  }

  // find and return the next available order_id number
  public function generateOrderId()
  {
    $q = Doctrine_Query::create()
        ->select('id, limelight_id, order_id')
        ->from('LimelightWiki')
        ->orderBy('order_id DESC');
    $result = $q->fetchOne();
    return isset($result['order_id']) ? $result['order_id'] + 1 : 1;
  }

  // get a wiki groups history
  public function getGroupHistory($group_id, $user_id, $page = 1)
  {
    $q = Doctrine_Query::create()
        ->select('w.*, wf.user_id AS flagged, ws.amount AS scored')
        ->from('Wiki w')
        ->leftJoin('w.Flags wf WITH wf.user_id = ?', $user_id)
        ->leftJoin('w.Scores ws WITH ws.user_id = ?', $user_id)
        ->where('group_id = ? AND status = ?', array($group_id, 'Active'))
        ->orderBy('version DESC')
        ->useResultCache(true, 86400, 'wiki_history_'.$group_id.'_'.$page.'_'.$user_id);

    if ($page)
      $q->offset(sfConfig::get('app_wiki_history_limit') * ($page - 1));

    $q->limit(sfConfig::get('app_wiki_history_limit'));

    return $q->fetchArray();
  }

  // get the currently active wiki revision within a wiki group
  public function getGroupActive($group_id, $user_id)
  {
    $q = Doctrine_Query::create()
        ->select('w.*, wf.user_id AS flagged, ws.amount AS scored')
        ->from('Wiki w')
        ->leftJoin('w.Flags wf WITH wf.user_id = ?', $user_id)
        ->leftJoin('w.Scores ws WITH ws.user_id = ?', $user_id)
        ->where('group_id = ? AND is_active = ?', array($group_id, 1))
        ->useResultCache(true, 300, 'wiki_history_active_'.$group_id.'_'.$user_id);

    $result = $q->fetchOne();
    if ($result['status'] == 'Active')
      return $result;

    // if we are continuing then the currently active wiki revision was probably
    // flagged at some point. We must unset it as active and set the next highest
    // revisiont o active.
    Doctrine_Query::create()
        ->update('Wiki')
        ->set('is_active', 0)
        ->where('id = ?', $result['id'])
        ->execute();

    Doctrine_Query::create()
        ->update('Wiki')
        ->set('is_active', 1)
        ->where('status = ?', 'Active')
        ->orderBy('version DESC')
        ->limit(1)
        ->execute();

    $q = Doctrine_Query::create()
        ->select('w.*, wf.user_id AS flagged, ws.amount AS scored')
        ->from('Wiki w')
        ->leftJoin('w.Flags wf WITH wf.user_id = ?', $user_id)
        ->leftJoin('w.Scores ws WITH ws.user_id = ?', $user_id)
        ->where('group_id = ? AND is_active = ?', array($group_id, 1))
        ->useResultCache(true, 300, 'wiki_history_active_'.$group_id.'_'.$user_id);

    return $q->fetchOne();
  }

  // get a specific wiki revision
  public function getRevision($wiki_id, $user_id)
  {
    $q = Doctrine_Query::create()
        ->select('w.*, wf.user_id AS flagged, ws.amount AS scored')
        ->from('Wiki w')
        ->leftJoin('w.Flags wf WITH wf.user_id = ?', $user_id)
        ->leftJoin('w.Scores ws WITH ws.user_id = ?', $user_id)
        ->where('w.id = ?', $wiki_id);

    return $q->fetchOne();
  }

  public function unsetGroupActive($group_id)
  {
    Doctrine_Query::create()
        ->update('Wiki')
        ->set('is_active', 0)
        ->where('group_id = ? AND is_active = ?', array($group_id, 1))
        ->execute();

    $cacheDriver = $this->getAttribute(Doctrine_Core::ATTR_RESULT_CACHE);
    $cacheDriver->deleteByPrefix('wiki_history_'.$group_id);
    $cacheDriver->deleteByPrefix('wiki_history_active_'.$group_id);
  }

  // get the limelights that use the given wiki group_id
  public function getLimelights($group_id)
  {
    $q = Doctrine_Query::create()
        ->select('lw.*, ll.*')
        ->from('LimelightWiki lw')
        ->leftJoin('lw.Limelight ll WITH ll.status = ?', 'Active')
        ->where('lw.wiki_group_id = ?', $group_id);

    $result = $q->fetchArray();
    $limelights = array();
    foreach ($result as $limelight_wiki)
    {
      $limelights[] = $limelight_wiki['Limelight'];
    }

    return $limelights;
  }

  // FOR LUCENE SEARCH
  static public function getLuceneIndex()
  {
    ProjectConfiguration::registerZend();

    Zend_Search_Lucene::setResultSetLimit(sfConfig::get('app_wiki_search_limit'));
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
    return sfConfig::get('sf_data_dir').'/wiki.'.sfConfig::get('sf_environment').'.index';
  }

  public function getForLuceneQuery($query, $ll_id = null)
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
        ->select('w.id, w.topics, w.group_id, lw.id as lw_id, lw.limelight_id AS linked')
        ->from('Wiki w')
        ->leftJoin('w.LimelightWikis lw WITH lw.limelight_id = ?', $ll_id)
        ->whereIn('w.group_id', $pks)
        ->andWhere('w.is_active = ?', 1)
        ->limit(sfConfig::get('app_wiki_search_limit'));

    $items = $q->execute();

    $results = array();
    foreach ($pks as $pk)
    {
      foreach ($items as $item)
      {
        if ($item['group_id'] == $pk)
          $results[] = $item;
      }
    }

    return $results;
  }
  // END LUCENE SEARCH
}