<?php

/**
 * content actions.
 *
 * @package    limelight
 * @subpackage content
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class contentActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeFeed($request)
  {
    // set META info
    $response = $this->getResponse();
    $response->addMeta('keywords', 'technology news, technology, technology information, news');
    $response->addMeta('description', 'Stay up to date on the latest technology news and information.
                                       Follow the latest technology news on your favorite technology products and companies.');

    $user = $this->getUser();
    $filters = null;
    if ($request->hasParameter('category'))
    {
      $filters['feed_type'] = $request->getParameter('feed_type', 'News');
      $filters['time_period'] = 1;
      $filters['sort_by'] = 'popularity';
      if ($request->getParameter('category') == 'all')
        $category_id = 0;
      else
      {
        $category = Doctrine::getTable('Category')->findOneByNameSlug($request->getParameter('category'));
        $category_id = (int)$category['id'];
      }
      $filters['categories'] = json_encode(array($category_id));
      $user->setAttribute('filters', $filters);
    }
    else if (!$user->getAttribute('filters') || ($this->getRequest()->isXmlHttpRequest() && $request->hasParameter('feed_type'))) {
      $filters['feed_type'] = $request->getParameter('feed_type', 'News');
      $filters['time_period'] = $request->getParameter('time_period', 1);
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

    $filters = $user->getAttribute('filters');

    $this->items = Doctrine::getTable($filters['feed_type'])->getByFilters(
      $filters['feed_type'],
      $filters['time_period'],
      $filters['sort_by'],
      json_decode($filters['categories']),
      sfConfig::get('app_main_feed_num'),
      sfConfig::get('app_main_feed_num') * ($request->getParameter('page', 1)-1)
    );
    $this->next_page = $request->getParameter('page', 1)+1;
    $this->feed_more_url = 'feed_more';

    if ($this->getRequest()->isXmlHttpRequest())
    {
      return $this->renderPartial('user/actionFeed', array(
        'items'         => $this->items,
        'next_page'     => $this->next_page,
        'feed_more_url' => $this->feed_more_url,
        'type'          => $filters['feed_type']
      ));
      return sfView::NONE;
    }
  }

  public function executeFilter($request)
  {
    if (!$this->getRequest()->isXmlHttpRequest())
      $this->forward404();

    if (!$request->getParameter('it') || !$request->getParameter('ci') || !$request->getParameter('tp') || !$request->getParameter('sb'))
      $this->forward404();

    $filters['it'] = $request->getParameter('it');
    $filters['ci'] = $request->getParameter('ci');
    $filters['tp'] = $request->getParameter('tp');
    $filters['sb'] = $request->getParameter('sb');
    $filters['c'] = $request->getParameter('categories');

    $this->getUser()->setAttribute('filters', $filters);

    return sfView::NONE;
  }

  public function executeTagSearchahead($request)
  {
    $items = Doctrine::getTable('Tag')->getSearchaheadList();
    $this->renderPartial('tagSearchahead.json', array('items' => $items));
    return sfView::NONE;
  }

  public function executeContribute(sfWebRequest $request)
  {
  }

  public function executeDisable(sfWebRequest $request)
  {
    $user = $this->getUser();
    if (!$user->isAuthenticated()) {
      $this->renderText('{ "result":"login" }');
      return sfView::NONE;
    }

    $user = $user->getGuardUser();
    $item_type = $request->getParameter('item_type');
    if (!$request->isXmlHttpRequest() || !$request->isMethod('post') || !$request->hasParameter('item_id')) {
      $this->renderText('{ "result":"error", "text":"There was an error while disabling this item. Please try again later" }');
      Doctrine::getTable('Log')->newLog($item_type.' disable', 'No ajax or not post or parameters missing.', $user->id, $_SERVER['REMOTE_ADDR']);
      return sfView::NONE;
    }

    if (!$user->hasPermission('disable')) {
      $this->renderText('{ "result":"error", "text":"You do not have permission to disable items" }');
      Doctrine::getTable('Log')->newLog($item_type.' disable', 'No permission.', $user->id, $_SERVER['REMOTE_ADDR']);
      return sfView::NONE;
    }

    $item_id = $request->getParameter('item_id');

    $item = Doctrine::getTable($item_type)->findOneById($item_id);
    $item->status = 'Disabled';
    $item->save();

    Doctrine::getTable('Log')->newLog($item_type.' disabled', $user->username.' disabled this ' . $item_type . ' item with ID ' . $item->id . '.', $user->id, $_SERVER['REMOTE_ADDR']);

    $this->renderText('{ "result":"success", "text":"'.$item_type.' item successfully disabled.", "new_text":"disabled" }');
    return sfView::NONE;
  }

  public function executeLockFunction(sfWebRequest $request)
  {
    $user = $this->getUser();
    if (!$user->isAuthenticated()) {
      $this->renderText('{ "result":"login" }');
      return sfView::NONE;
    }

    $user = $user->getGuardUser();
    $item_type = $request->getParameter('item_type');
    $lock = $request->getParameter('lock');
    if (!$request->isXmlHttpRequest() || !$request->isMethod('post') || !$request->hasParameter('item_id') || !$user->hasPermission('function_lock')) {
      $this->renderText('{ "result":"error", "text":"You do not have permission to change the tags lock settings on news pages." }');
      Doctrine::getTable('Log')->newLog('lock', $item_type.' '.$lock.' lock error.', $user->id, $_SERVER['REMOTE_ADDR']);
      return sfView::NONE;
    }

    $text = array('disabled', 'enabled');
    $item_id = $request->getParameter('item_id');
    $item = Doctrine::getTable($item_type)->findOneById($item_id);
    $item->$lock = $item->$lock == 0 ? 1 : 0;
    $item->save();

    $cacheManager = $this->getContext()->getViewCacheManager();
    if ($cacheManager) {
      if ($item_type == 'News')
      {
        if ($lock == 'comment_lock')
          $cacheManager->remove('@sf_cache_partial?module=comment&action=_showComments&sf_cache_key=comments_News_'.$item_id.'-*');
      }
    }

    Doctrine::getTable('Log')->newLog($item_type.' '.$lock.' '.$text[$item->$lock], $user->username.' '.$text[$item->$lock].' the '.$lock.' of the '.$item_type.' item with ID '.$item->id.'.', $user->id, $_SERVER['REMOTE_ADDR']);

    $this->renderText('{ "result":"success", "text":"'.$item_type.' '.$lock.' successfully '.$text[$item->$lock].' for this '.$item_type.' item.", "new_text":"'.$lock.' '.$text[$item->$lock].'" }');
    return sfView::NONE;
  }

  public function executeRateBox(sfWebRequest $request)
  {
    $user = $this->getUser();
    $result_data;
    if (!$user->isAuthenticated()) {
      $result_data['result'] = 'login';
      $this->renderText(json_encode($result_data));
      return sfView::NONE;
    }
    $user = $user->getGuardUser();

    $scoreOptions = array('plus', 'minus');
    $item_type = $request->getParameter('item_type');
    if (!$request->isXmlHttpRequest() || !$request->isMethod('get') || !$request->hasParameter('id')) {
      $result_data = array('result' => 'error', 'text' => 'There was an error. Please try again later. If the problem persists, please submit the problem via the feedback link or contact us.');
      $this->renderText(json_encode($result_data));
      Doctrine::getTable('Log')->newLog('score '.$item_type, 'there was an error while trying to show a scoreBox for a '.$item_type.' item.', $user->id, $_SERVER['REMOTE_ADDR']);
      return sfView::NONE;
    }

    $id = $request->getParameter('id');
    $scoreClass = $item_type.'Score';

    $scored = Doctrine::getTable('Score')->checkScored($scoreClass, $id, $user->id);

    $this->renderPartial('rateBox', array('scored' => $scored['amount'], 'created_at' => $scored['created_at'], 'item_type' => $item_type, 'id' => $id));
    return sfView::NONE;
  }

  // update item scores
  public function executeUpdateScore(sfWebRequest $request)
  {
    $user = $this->getUser();
    if (!$user->isAuthenticated()) {
      $result_data['result'] = 'login';
      $this->renderText(json_encode($result_data));
      return sfView::NONE;
    }
    $user = $user->getGuardUser();
    $scoreOptions = array('up', 'down');
    $item_type = $request->getParameter('item_type');
    if (!$request->isXmlHttpRequest() || !$request->isMethod('post') || !$request->hasParameter('id') || !$request->hasParameter('d') || !in_array($request->getParameter('d'), $scoreOptions)) {
      Doctrine::getTable('Log')->newLog('score '.$item_type, 'there was an error while trying to score a '.$item_type.' item.', $user->id, $_SERVER['REMOTE_ADDR']);
      $result_data = array('result' => 'error', 'text' => 'There was an error while trying to score this item. Please try again later.');
      $this->renderText(json_encode($result_data));
      return sfView::NONE;
    }

    $d = $request->getParameter('d');

    if ($d == 'down' && !$user->hasPermission('downvote')) {
      $result_data = array('result' => 'error', 'text' => 'You must have a minimum score of '.LimelightUtils::getUserActionMinScore('downvote').' to downvote items');
      $this->renderText(json_encode($result_data));
      return sfView::NONE;
    }
    if ($d == 'down' && !$user->canVote())
    {
      $result_data = array('result' => 'error', 'text' => 'You\'ve downvoted too many items, you\'re positive/negative score ratio must be above '.sfConfig::get('app_user_score_ratio_min').' (currently '.$user->Profile->score_ratio.'). Try scoring more items that you like.');
      $this->renderText(json_encode($result_data));
      return sfView::NONE;
    }

    $amount = ($d == 'up') ? 1 : -1;

    $item_id = $request->getParameter('id');
    $scoreClass = $item_type.'Score';
    $item = Doctrine::getTable($item_type)->findOneById($item_id);
    if (!$item || $item->status != 'Active')
    {
      $result_data = array('result' => 'error', 'text' => 'The item you are trying to score does not exist or has been flagged/disabled');
      $this->renderText(json_encode($result_data));
      return sfView::NONE;
    }
    if ($item->user_id == $user->id)
    {
      $result_data = array('result' => 'error', 'text' => 'You cannot score your own items');
      $this->renderText(json_encode($result_data));
      return sfView::NONE;
    }

    $scored = Doctrine::getTable('Score')->checkScored($scoreClass, $item_id, $user->id);
    if ($scored)
    {
      $result_data = array('result' => 'error', 'text' => 'You\'ve already scored this item. You may only score each item once.');
      $this->renderText(json_encode($result_data));
      return sfView::NONE;
    }

    $s = new $scoreClass();
    $s->user_id = $user->id;
    $s->amount = $amount;
    $s->item_id = $item->id;
    // if there is a target user involved (limelights do not affect the contributing users score)
    if ($item_type != 'Limelight')
    {
      $s->target_user_id = $item->user_id;
      $result_data['user_id'] = $item->user_id;
    }
    $s->save();
    
    $cacheManager = $this->getContext()->getViewCacheManager();
    if ($cacheManager) {
      if ($item_type == 'Comment')
        $cacheManager->remove('@sf_cache_partial?module=comment&action=_showComments&sf_cache_key=comments_'.$item->type.'_'.$item->id.'-'.$user->id);
    }

    $result_data['result'] = 'success';
    $result_data['amount'] = $s->amount;
    $this->renderText(json_encode($result_data));
    return sfView::NONE;
  }

  public function executeFlagBox(sfWebRequest $request) {
    
    $user = $this->getUser();
    $result_data;
    if (!$user->isAuthenticated()) {
      $result_data['result'] = 'login';
      $this->renderText(json_encode($result_data));
      return sfView::NONE;
    }
    $user = $user->getGuardUser();

    $item_type = $request->getParameter('item_type');
    if (!$request->isXmlHttpRequest() || !$request->isMethod('get') || !$request->hasParameter('id')) {
      $result_data = array('result' => 'error', 'text' => 'There was an error. Please try again later. If the problem persists, please submit the problem via the side feedback button or contact us.');
      $this->renderText(json_encode($result_data));
      Doctrine::getTable('Log')->newLog('flag '.$item_type, 'there was an error while trying to show a flagBox for a '.$item_type.' item.', $user->id, $_SERVER['REMOTE_ADDR']);
      return sfView::NONE;
    }

    $id = $request->getParameter('id');
    $flagClass = $item_type.'Flag';

    $flagged = Doctrine::getTable('Flag')->checkFlagged($flagClass, $id, $user->id);
    if ($flagged['id'])
    {
      $text = 'flagged as \''.$flagged['type'].'\' on '.date('M j', strtotime($flagged['created_at']));
    }
    else
    {
      $text = null;
    }

    $this->renderPartial('flagBox', array('flagged' => $text, 'item_type' => $item_type, 'id' => $id));
    return sfView::NONE;
  }

  public function executeFlag(sfWebRequest $request)
  {
    $user = $this->getUser();
    if (!$user->isAuthenticated()) {
      $result_data['result'] = 'login';
      $this->renderText(json_encode($result_data));
      return sfView::NONE;
    }

    $user = $user->getGuardUser();
    $item_type = $request->getParameter('item_type', null);
    $item_id = $request->getParameter('id', null);
    $flag_type = $request->getParameter('type', null);

    if (!$request->isXmlHttpRequest() || !$request->isMethod('post') || !$item_type || !$item_id || !$flag_type) {
      Doctrine::getTable('Log')->newLog('flag '.$item_type, 'there was an error while trying to flag a '.$item_type.' item.', $user->id, $_SERVER['REMOTE_ADDR']);
      $result_data = array('result' => 'error', 'text' => 'There was an error while trying to flag this item. Please try again later.');
      $this->renderText(json_encode($result_data));
      return sfView::NONE;
    }

    if (!$user->hasPermission('flag')) {
      $result_data = array('result' => 'error', 'text' => 'You must have a minimum score of ' . LimelightUtils::getUserActionMinScore('flag') . ' in order to flag items');
      $this->renderText(json_encode($result_data));
      return sfView::NONE;
    }

    $flagged = Doctrine::getTable('Flag')->flag($user->id, $item_id, $item_type, $flag_type);

    if ($flagged) {
      $result_data = array('result' => 'error', 'text' => 'You flagged this item on ' . date('M j', strtotime($flagged['created_at'])));
      $this->renderText(json_encode($result_data));
      return sfView::NONE;
    }

    $result_data['result'] = 'success';
    $this->renderText(json_encode($result_data));
    return sfView::NONE;
  }

  public function executeFollowBox(sfWebRequest $request) {

    $user = $this->getUser();
    $result_data;
    if (!$user->isAuthenticated()) {
      $result_data['result'] = 'login';
      $this->renderText(json_encode($result_data));
      return sfView::NONE;
    }
    $user = $user->getGuardUser();

    $item_type = $request->getParameter('item_type');
    if (!$request->isXmlHttpRequest() || !$request->isMethod('get') || !$request->hasParameter('id')) {
      $result_data = array('result' => 'error', 'text' => 'There was an error. Please try again later. If the problem persists, please submit the problem via the side feedback button or contact us.');
      $this->renderText(json_encode($result_data));
      Doctrine::getTable('Log')->newLog('follow '.$item_type, 'there was an error while trying to show a followBox for a '.$item_type.' item.', $user->id, $_SERVER['REMOTE_ADDR']);
      return sfView::NONE;
    }

    $id = $request->getParameter('id');
    $followClass = 'Follow'.$item_type.'Reference';

    $following = Doctrine::getTable($followClass)->checkFollowing($user->id, $id);
    $following = $following ? 'unfollow' : 'follow';
    $this->renderPartial('followBox', array('following' => $following, 'item_type' => $item_type, 'id' => $id));
    return sfView::NONE;
  }

  public function executeFollow(sfWebRequest $request)
  {
    $user = $this->getUser();
    if (!$user->isAuthenticated()) {
      $result_data['result'] = 'login';
      $this->renderText(json_encode($result_data));
      return sfView::NONE;
    }

    $user = $user->getGuardUser();
    $item_type = $request->getParameter('item_type', null);
    $follow_item_id = $request->getParameter('id', null);
    
    if (!$request->isXmlHttpRequest() || !$request->isMethod('post') || !$item_type || !$follow_item_id) {
      Doctrine::getTable('Log')->newLog('follow '.$item_type, 'there was an error while trying to follow a '.$item_type.' item.', $user->id, $_SERVER['REMOTE_ADDR']);
      $result_data = array('result' => 'error', 'text' => 'There was an error while trying to follow this item. Please try again later.');
      $this->renderText(json_encode($result_data));
      return sfView::NONE;
    }

    switch ($item_type)
    {
      case 'User':
        $uf = new FollowUserReference();
        $uf->user1_id = $user->id;
        $uf->user2_id = $follow_item_id;
        $uf->save();
        $result_data['text'] = 'You\'ve added another user to your following user feed. Find the feed in your user account.';
        break;
      case 'Limelight':
        $lf = new FollowLimelightReference();
        $lf->user_id = $user->id;
        $lf->limelight_id = $follow_item_id;
        $lf->save();
        $result_data['text'] = 'You\'ve added another limelight to your following limelight feed. Find the feed in your user account.';
        break;
    }

    $result_data['result'] = 'success';
    $this->renderText(json_encode($result_data));
    return sfView::NONE;
  }

  public function executeUnfollow(sfWebRequest $request)
  {
    $user = $this->getUser();
    if (!$user->isAuthenticated()) {
      $result_data['result'] = 'login';
      $this->renderText(json_encode($result_data));
      return sfView::NONE;
    }

    $user = $user->getGuardUser();
    $item_type = $request->getParameter('item_type', null);
    $follow_item_id = $request->getParameter('id', null);

    if (!$request->isXmlHttpRequest() || !$request->isMethod('post') || !$item_type || !$follow_item_id) {
      Doctrine::getTable('Log')->newLog('unfollow '.$item_type, 'there was an error while trying to unfollow a '.$item_type.' item.', $user->id, $_SERVER['REMOTE_ADDR']);
      $result_data = array('result' => 'error', 'text' => 'There was an error while trying to stop following this item. Please try again later.');
      $this->renderText(json_encode($result_data));
      return sfView::NONE;
    }

    switch ($item_type)
    {
      case 'User':
        $result_data['text'] = 'You have stopped following a user.';
        break;
      case 'Limelight':
        $result_data['text'] = 'You have stopped following a limelight.';
        break;
    }

    $deleted = Doctrine::getTable('Follow'.$item_type.'Reference')->stopFollowing($user->id, $follow_item_id);
    if (!$deleted)
    {
      Doctrine::getTable('Log')->newLog('unfollow '.$item_type, 'there was an error while trying to delete a follow record for a '.$item_type.' item.', $user->id, $_SERVER['REMOTE_ADDR']);
      $result_data = array('result' => 'error', 'text' => 'There was an error while trying to stop following this item. Please try again later.');
      $this->renderText(json_encode($result_data));
      return sfView::NONE;
    }

    $result_data['result'] = 'success';
    $result_data['new_text'] = 'removed';
    $this->renderText(json_encode($result_data));
    return sfView::NONE;
  }

  public function executeFavoriteBox(sfWebRequest $request) {

    $user = $this->getUser();
    $result_data;
    if (!$user->isAuthenticated()) {
      $result_data['result'] = 'login';
      $this->renderText(json_encode($result_data));
      return sfView::NONE;
    }
    $user = $user->getGuardUser();

    $item_type = $request->getParameter('item_type');
    if (!$request->isXmlHttpRequest() || !$request->isMethod('get') || !$request->hasParameter('id')) {
      $result_data = array('result' => 'error', 'text' => 'There was an error. Please try again later. If the problem persists, please submit the problem via the side feedback button or contact us.');
      $this->renderText(json_encode($result_data));
      Doctrine::getTable('Log')->newLog('favorite '.$item_type, 'there was an error while trying to show a favoriteBox for a '.$item_type.' item.', $user->id, $_SERVER['REMOTE_ADDR']);
      return sfView::NONE;
    }

    $id = $request->getParameter('id');
    $favoriteClass = $item_type.'Favorite';

    $favorite = Doctrine::getTable('Favorite')->checkFavorite($user->id, $id, $favoriteClass);
    $favorite = $favorite ? 'unfavorite' : 'favorite';
    $this->renderPartial('favoriteBox', array('favorite' => $favorite, 'item_type' => $item_type, 'id' => $id));
    return sfView::NONE;
  }

  public function executeFavorite(sfWebRequest $request)
  {
    $user = $this->getUser();
    if (!$user->isAuthenticated()) {
      $result_data['result'] = 'login';
      $this->renderText(json_encode($result_data));
      return sfView::NONE;
    }

    $user = $user->getGuardUser();
    $item_type = $request->getParameter('item_type', null);
    $item_id = $request->getParameter('id', null);

    if (!$request->isXmlHttpRequest() || !$request->isMethod('post') || !$item_type || !$item_id) {
      Doctrine::getTable('Log')->newLog('favorite '.$item_type, 'there was an error while trying to favorite a '.$item_type.' item.', $user->id, $_SERVER['REMOTE_ADDR']);
      $result_data = array('result' => 'error', 'text' => 'There was an error while trying to favorite this item. Please try again later.');
      $this->renderText(json_encode($result_data));
      return sfView::NONE;
    }

    $fclass = $item_type.'Favorite';
    $f = new $fclass;
    $f->user_id = $user->id;
    $f->item_id = $item_id;
    $f->save();

    switch ($item_type)
    {
      case 'News':
        $result_data['text'] = 'You\'ve added another news story to your favorites list. Find the list in your user account.';
        break;
      case 'Limelight':
        $result_data['text'] = 'You\'ve added another limelight to your favorites list. Find the list in your user account.';
        break;
    }

    $result_data['result'] = 'success';
    $this->renderText(json_encode($result_data));
    return sfView::NONE;
  }

  public function executeUnfavorite(sfWebRequest $request)
  {
    $user = $this->getUser();
    if (!$user->isAuthenticated()) {
      $result_data['result'] = 'login';
      $this->renderText(json_encode($result_data));
      return sfView::NONE;
    }

    $user = $user->getGuardUser();
    $item_type = $request->getParameter('item_type', null);
    $item_id = $request->getParameter('id', null);

    if (!$request->isXmlHttpRequest() || !$request->isMethod('post') || !$item_type || !$item_id) {
      Doctrine::getTable('Log')->newLog('unfavorite '.$item_type, 'there was an error while trying to unfavorite a '.$item_type.' item.', $user->id, $_SERVER['REMOTE_ADDR']);
      $result_data = array('result' => 'error', 'text' => 'There was an error while trying to unfavorite this item. Please try again later.');
      $this->renderText(json_encode($result_data));
      return sfView::NONE;
    }

    switch ($item_type)
    {
      case 'News':
        $result_data['text'] = 'You have unfavorited this news story.';
        break;
      case 'Limelight':
        $result_data['text'] = 'You have unfavorited this limelight.';
        break;
    }

    $deleted = Doctrine::getTable('Favorite')->unFavorite($user->id, $item_id, $item_type.'Favorite');
    if (!$deleted)
    {
      Doctrine::getTable('Log')->newLog('unfavorite '.$item_type, 'there was an error while trying to unfavorite a '.$item_type.' item.', $user->id, $_SERVER['REMOTE_ADDR']);
      $result_data = array('result' => 'error', 'text' => 'There was an error while trying to unfavorite this item. Please try again later.');
      $this->renderText(json_encode($result_data));
      return sfView::NONE;
    }

    $result_data['result'] = 'success';
    $result_data['new_text'] = 'unfavorited';
    $this->renderText(json_encode($result_data));
    return sfView::NONE;
  }
}