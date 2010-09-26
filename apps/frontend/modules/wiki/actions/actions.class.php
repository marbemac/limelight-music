<?php

/**
 * wiki actions.
 *
 * @package    wiki
 * @subpackage wiki
 * @author     marc
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class wikiActions extends sfActions
{
 public function executeLoadEditor(sfWebRequest $request)
  {
    if (!$request->isXmlHttpRequest())
      $this->forward404;

    $user = $this->getUser();
    if (!$user->isAuthenticated()) {
      $this->renderText('{ "result":"login" }');
      return sfView::NONE;
    }

    $user = $user->getGuardUser();

    $wiki = Doctrine::getTable('Wiki')->find($request->getParameter('id', null));
    $ll = Doctrine::getTable('Limelight')->findOneByNameSlug(LimelightUtils::slugify($wiki['topics']));
    if (!(isset($ll) && $ll['is_stub'] && $user->hasPermission('stub_edit')) && !$user->hasPermission('wiki_submit')) {
      if ($ll['is_stub'])
        $return_data = array('result' => 'error', 'text' => 'You cannot edit limelight stubs, you must have a score of at least '.LimelightUtils::getUserActionMinScore('edit a limelight stub').'.');
      else
        $return_data = array('result' => 'error', 'text' => 'You cannot edit wikis, you must have a score of at least '.LimelightUtils::getUserActionMinScore('submit a wiki revision').' to do this.');
      $this->renderText(json_encode($return_data));
      return sfView::NONE;
    }

    if ($wiki->edit_lock && time() - strtotime($wiki['edit_lock_time']) < sfConfig::get('app_wiki_edit_inactivity_limit') && $wiki['edit_lock_user_id'] != $user->id)
    {
      $this->renderText('{ "result":"error", "text":"This wiki section is currently being edited by another user. The user performed his/her last edit at @ '.date('M j, g:i:s a', strtotime($wiki->edit_lock_time)).'. Please try again later." }');
      return sfView::NONE;
    }

    $editing = Doctrine::getTable('Wiki')->isEditing($user->id);
    if (isset($editing['id']))
    {
      $this->renderText('{ "result":"error", "text":"You are currently editing another wiki segment.  Please finish editing that wiki segment before attempting to edit another one." }');
      return sfView::NONE;
    }

    $wiki->edit_lock = true;
    $wiki->edit_lock_start = date("Y-m-d H:i:s");
    $wiki->edit_lock_time = date("Y-m-d H:i:s");
    $wiki->edit_lock_user_id = $user->id;
    $wiki->save();

    $this->getUser()->setAttribute('wiki_edit', $wiki->id);

    $this->renderText('{ "result":"success" }');
    return sfView::NONE;
  }

  public function executeUpdateEditor(sfWebRequest $request)
  {
    if (!$request->isXmlHttpRequest())
      $this->forward404;

    $user = $this->getUser();

    $wiki = Doctrine::getTable('Wiki')->find($request->getParameter('id', null));

    $wiki->edit_lock_time = date ("Y-m-d H:i:s");
    $wiki->save();

    return sfView::NONE;
  }

  // unlock the wiki section
  public function executeUnloadEditor(sfWebRequest $request)
  {
    if (!$request->isXmlHttpRequest())
      $this->forward404;

    $user = $this->getUser();
    if (!$user->isAuthenticated()) {
      $this->renderText('{ "result":"login" }');
      return sfView::NONE;
    }

    $wiki = Doctrine::getTable('Wiki')->find($request->getParameter('id', null));
    $wiki->edit_lock = 0;
    $wiki->edit_lock_start = null;
    $wiki->edit_lock_user_id = null;
    $wiki->save();

    $this->getUser()->setAttribute('wiki_edit', false);

    if ($request->getParameter('code', 2) == 0)
      $user->setFlash('notice', 'The wiki section you were editing has been unlocked and any unsaved changes you made have been discarded due to '.(sfConfig::get('app_wiki_edit_inactivity_limit')/60).' minutes of inactivity.');
    else if ($request->getParameter('code', 2) == 1)
      $user->setFlash('notice', 'You have exceeded the '.(sfConfig::get('app_wiki_edit_max_time_limit')/60).' minute editing time limit. The wiki section you were editing has been unlocked and any unsaved changes you made have been discarded.');

    return sfView::NONE;
  }

  public function executeSave(sfWebRequest $request)
  {
    $user = $this->getUser();
    if (!$user->isAuthenticated()) {
      $this->renderText('{ "result":"login" }');
      return sfView::NONE;
    }
    $user = $user->getGuardUser();

    $content = trim($request->getParameter('content', null));
    $edit_type = $request->getParameter('edit_type', null);
    $note = $request->getParameter('note', null);

    if (!$request->isXmlHttpRequest() || !$content || !$edit_type || !$note) {
      $this->renderText('{ "result":"error", "text":"There was an error. Please try again later." }');
      Doctrine::getTable('Log')->newLog('wiki submit', 'No ajax or not post or parameters missing.', $user->id, $_SERVER['REMOTE_ADDR']);
      return sfView::NONE;
    }

    // set the old wiki to inactive
    $wiki = Doctrine::getTable('Wiki')->find($request->getParameter('id', null));

    if (trim($wiki->content) == $content || $content == '')
    {
      $this->renderText('{ "result":"error", "text":"You must make revisions. You cannot submit a blank revision." }');
      return sfView::NONE;
    }

    $wiki->edit_lock = 0;
    $wiki->edit_lock_start = null;
    $wiki->edit_lock_user_id = null;
    $wiki->is_active = 0;
    $wiki->save();

    // create the new wiki
    $w = new Wiki();
    $w->user_id = $user->id;
    $w->topics = $wiki->topics;
    $w->content = $content;
    $w->note = $note;
    $w->version = intval(Doctrine::getTable('Wiki')->getMaxVersion($wiki->group_id)) + 1;
    $w->is_active = 1;
    $w->edit_type = $edit_type;
    $w->group_id = $wiki->group_id;
    $w->save();

    $this->getUser()->setAttribute('wiki_edit', false);
    $this->getUser()->setFlash('notice', 'Success!  Your wiki revisions have been saved.');

    $this->renderText('{ "result":"success" }');
    return sfView::NONE;
  }

  public function executeResort(sfWebRequest $request)
  {
    $user = $this->getUser();
    if (!$user->isAuthenticated()) {
      $this->renderText('{ "result":"login" }');
      return sfView::NONE;
    }
    if (!$user->hasPermission('wiki_sort'))
    {
      $this->renderText('{ "result":"error", "text":"There was an error. Please try again later." }');
      Doctrine::getTable('Log')->newLog('wiki sort', 'Wiki sort permission not present.', $user->id, $_SERVER['REMOTE_ADDR']);
      return sfView::NONE;
    }

    $user = $user->getGuardUser();
    $order = $request->getParameter('order');

    Doctrine::getTable('Wiki')->resort($order);
    $this->renderText('{ "result":"success" }');
    return sfView::NONE;
  }

  public function executeNewSegment(sfWebRequest $request)
  {
    $user = $this->getUser();
    if (!$user->isAuthenticated()) {
      $this->renderText('{ "result":"login" }');
      return sfView::NONE;
    }
    if (!$user->hasPermission('wiki_segment_add'))
    {
      $this->renderText('{ "result":"error", "text":"You cannot add new wiki segments, you must have a score of at least '.LimelightUtils::getUserActionMinScore('add a new wiki segment').' to do this." }');
      return sfView::NONE;
    }

    $user = $user->getGuardUser();
    if ($request->isMethod('POST'))
    {
      $ll_id = $request->getParameter('ll_id');
      $name = $request->getParameter('name');
      $content = $request->getParameter('content');
      $group_id = Doctrine::getTable('Wiki')->generateGroupId();

      $w = new Wiki();
      $w->user_id = $user->id;
      $w->topics = $name;
      $w->content = $content;
      $w->note = 'initial submit';
      $w->version = 1;
      $w->is_active = 1;
      $w->edit_type = 'major';
      $w->group_id = $group_id;
      $w->save();

      $lw = new LimelightWiki();
      $lw->limelight_id = $ll_id;
      $lw->wiki_group_id = $w->group_id;
      $lw->order_id = Doctrine::getTable('Wiki')->generateOrderId($ll_id);
      $lw->save();

      $this->getUser()->setFlash('notice', 'Wiki segment successfully created and linked to this wiki.');
      $this->renderText('{ "result":"success" }');
      return sfView::NONE;
    }
    else
    {
      $this->renderText('{ "result":"success" }');
      return sfView::NONE;
    }
  }

  public function executeFindSegments(sfWebRequest $request)
  {
    if (!$query = $request->getParameter('q'))
    {
      $this->renderText('{ "result":"error" }');
      return sfView::NONE;
    }
    $ll_id = $request->getParameter('ll_id', null);
    $items = Doctrine::getTable('Wiki')->getForLuceneQuery($query, $ll_id);
    $this->renderPartial('wikiSearch.json', array('items' => $items, 'll_id' => $ll_id));
    return sfView::NONE;
  }

  public function executeGetSegment(sfWebRequest $request)
  {
    $item = Doctrine::getTable('Wiki')->find($request->getParameter('id', null));
    $this->renderPartial('segmentPreview', array('item' => $item));
    return sfView::NONE;
  }

  public function executeLinkSegment(sfWebRequest $request)
  {
    $user = $this->getUser();
    if (!$user->isAuthenticated()) {
      $this->renderText('{ "result":"login" }');
      return sfView::NONE;
    }
    if (!$user->hasPermission('wiki_segment_link'))
    {
      $this->renderText('{ "result":"error", "text":"You cannot link wiki segments, you must have a score of at least '.LimelightUtils::getUserActionMinScore('link a wiki segment').' to do this." }');
      return sfView::NONE;
    }

    $user = $user->getGuardUser();
    $ll_id = $request->getParameter('ll_id');
    $group_id = $request->getParameter('group_id');

    $lw = new LimelightWiki();
    $lw->limelight_id = $ll_id;
    $lw->wiki_group_id = $group_id;
    $lw->order_id = Doctrine::getTable('Wiki')->generateOrderId($ll_id);
    $lw->save();

    $this->renderText('{ "result":"success", "text":"Wiki segment successfully linked to this wiki.", "type":"link" }');
    return sfView::NONE;
  }

  public function executeUnlinkSegment(sfWebRequest $request)
  {
    $user = $this->getUser();
    if (!$user->isAuthenticated()) {
      $this->renderText('{ "result":"login" }');
      return sfView::NONE;
    }
    if (!$user->hasPermission('wiki_segment_unlink'))
    {
      $this->renderText('{ "result":"error", "text":"You cannot unlink wiki segments, you must have a score of at least '.LimelightUtils::getUserActionMinScore('unlink a wiki segment').' to do this." }');
      return sfView::NONE;
    }

    $id = $request->getParameter('id');
    Doctrine::getTable('LimelightWiki')->find($id)->delete();

    $this->renderText('{ "result":"success", "text":"Wiki segment successfully unlinked from this wiki.", "type":"unlink" }');
    return sfView::NONE;
  }

  public function executeHistory(sfWebRequest $request)
  {
    $user = $this->getUser();
    if (!$user->isAuthenticated())
      $this->user_id = 0;
    else
      $this->user_id = $user->getGuardUser()->id;

    $group_id = $request->getParameter('group_id', null);
    $this->active_revision = Doctrine::getTable('Wiki')->getGroupActive($group_id, $this->user_id);
    $this->revisions = Doctrine::getTable('Wiki')->getGroupHistory($group_id, $this->user_id, $request->getParameter('page', 1));
  }
  
  public function executeRevision(sfWebRequest $request)
  {
    $user = $this->getUser();
    if (!$user->isAuthenticated())
      $user_id = 0;
    else
      $user_id = $user->getGuardUser()->id;

    $wiki_id = $request->getParameter('item_id', null);
    $this->revision = Doctrine::getTable('Wiki')->getRevision($wiki_id, $user_id);
  }

  public function executeRevert(sfWebRequest $request)
  {
    $user = $this->getUser();
    if (!$user->isAuthenticated()) {
      $this->renderText('{ "result":"login" }');
      return sfView::NONE;
    }

    $user = $user->getGuardUser();
    if (!$user->hasPermission('wiki_submit')) {
      $this->renderText('{ "result":"error", "text":"You cannot revert wikis revisions, you must have a score of at least '.LimelightUtils::getUserActionMinScore('submit a wiki revision').' to do this." }');
      return sfView::NONE;
    }

    $update = Doctrine::getTable('Wiki')->unsetGroupActive($request->getParameter('group_id', null));

    $wiki = Doctrine::getTable('Wiki')->find($request->getParameter('item_id', null));
    $wiki->is_active = true;
    $wiki->save();

    $this->renderText('{ "result":"success" }');

    $this->getUser()->setFlash('notice', 'The ' . $wiki['topics'] . ' wiki segment has successfully been reverted to version ' . $wiki['version'] . '.');

    return sfView::NONE;
  }
}