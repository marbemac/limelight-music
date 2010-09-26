<?php

/**
 * comment actions.
 *
 * @package    comment
 * @subpackage comment
 * @author     marc
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class commentActions extends sfActions
{
  public function executeAddForm($request) {
    $item_id = $request->getParameter('item_id', null);
    $parent_id = $request->getParameter('parent_id', 0);
    $type = $request->getParameter('type');
    $form = new CommentForm();
    $this->renderPartial('add', array('item_id' => $item_id, 'parent_id' => $parent_id, 'type' => $type, 'form' => $form));
    return sfView::NONE;
  }

  public function executeAdd($request)
  {
    $user = $this->getUser();
    if (!$user->isAuthenticated()) {
      $this->renderText('{ "result":"login" }');
      return sfView::NONE;
    }
    $user = $user->getGuardUser();

    $type = $request->getParameter('type', 'type error');
    if (!$request->isXmlHttpRequest() || !$request->isMethod('post') || !$request->hasParameter('item_id') || !$request->hasParameter('type') || !$request->hasParameter('comment')) {
      $this->renderText('{ "result":"error", "text":"There was an error while adding your comment. Please try again later" }');
      Doctrine::getTable('Log')->newLog($type.' comment', 'No ajax or not post or parameters missing.', $user->id, $_SERVER['REMOTE_ADDR']);
      return sfView::NONE;
    }

    if (strlen(trim($request->getParameter('comment'), ' ')) == 0) {
      $this->renderText('{ "result":"error", "text":"You cannot submit an empty comment." }');
      return sfView::NONE;
    }

    $item_id = $request->getParameter('item_id');
    $parent_id = $request->getParameter('parent_id');
    $comment = nl2br(substr($request->getParameter('comment'), 0, sfConfig::get('app_comment_max_length')));

    $type_column = $type.'_id';
    $c = new Comment();
    $c->content = $comment;
    $c->type = $type;
    if ($parent_id != 0)
      $c->parent_id = $parent_id;
    $c->user_id = $user->id;
    $c->$type_column = $item_id;
    $c->save();

    $cacheManager = $this->getContext()->getViewCacheManager();
    if ($cacheManager)
      $cacheManager->remove('@sf_cache_partial?module=comment&action=_showComments&sf_cache_key=comments_'.$type.'_'.$item_id.'-*');

    $this->getUser()->setFlash('comment_'.$parent_id, 'your comment was added successfully!');
    $this->renderText('{ "result":"success" }');
    return sfView::NONE;
  }
}