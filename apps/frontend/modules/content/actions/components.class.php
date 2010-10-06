<?php

class contentComponents extends sfComponents
{
  public function executeNone()
  {
  }

  public function executeFilter()
  {
    $categoryTable = Doctrine::getTable('Category');
    $this->cat1 = $categoryTable->getCategories(1);
    $this->cat2 = $categoryTable->getCategories(2);
  }

  public function executeFilterTab()
  {
    $filter_text = array('NewsLink' => array('add' => 'add this source to your power filter', 'remove' => 'remove this source from your power filter'),
                         'NewsTag'  => array('add' => 'add this news tag to your power filter', 'remove' => 'remove this news tag from your power filter'));

    $user = $this->getUser();

    $filter_elems = $user->getAttribute('filter_'.$this->item_type, null);

    if ($filter_elems && in_array($this->id, $filter_elems))
      $status = 'remove';
    else
      $status = 'add';

    $this->filter_text = $filter_text[$this->item_type][$status];
  }

  public function executeFeedNews()
  {
    $this->item = Doctrine::getTable('News')->getForFeed($this->id);
  }

  public function executeFeedSong()
  {
    $this->item = Doctrine::getTable('Song')->getForFeed($this->id);
  }

  public function executeFeedLimelight()
  {
    $this->item = Doctrine::getTable('Limelight')->getForFeed($this->id);
  }

  public function executeFeedComment()
  {
    $this->item = Doctrine::getTable('Comment')->getForFeed($this->id);
  }

  public function executeCategoryRibbon($request) {
    $user = $this->getUser();
    if (!$user->getAttribute('filters') || $this->getRequest()->isXmlHttpRequest()) {
      $filters['feed_type'] = $request->getParameter('feed_type', 'News');
      $filters['time_period'] = $request->getParameter('time_period', 3);
      $filters['sort_by'] = $request->getParameter('sort_by', 'popularity');
      $tmp_cats = $request->getParameter('categories', 0);
      if ($tmp_cats == 0)
      {
        $filters['categories'] = json_encode(array(0));
      }
      else
      {
        $cats = array();
        foreach ($tmp_cats AS $cat)
          $cats[] = (int)$cat;
        $filters['categories'] = json_encode($cats);
      }
      $user->setAttribute('filters', $filters);
    }

    $this->categories = Doctrine::getTable('Category')->getCategories();
  }

  public function executeScoreBoxFull()
  {
    $user_id = $this->getUser()->isAuthenticated() ? $this->getUser()->getGuardUser()->id : 0;

    $this->data = Doctrine::getTable($this->type)->getScoreboxInfo($this->item_id, $user_id);
  }

  public function executeFavorite()
  {
    $user_id = $this->getUser()->isAuthenticated() ? $this->getUser()->getGuardUser()->id : 0;

    $this->favorited = $user_id != 0 ? Doctrine::getTable('Favorite')->checkFavorite($user_id, $this->item_id, $this->type.'Favorite') : false;
  }
}