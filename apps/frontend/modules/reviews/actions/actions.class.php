<?php

/**
 * reviews actions.
 *
 * @package    limelight
 * @subpackage reviews
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class reviewsActions extends sfActions
{
  public function preExecute()
  {
    if (!$this->request->isXmlHttpRequest())
      $this->forward404;

    $this->user = $this->getUser()->getGuardUser();
  }

  public function executeNewUserReview(sfWebRequest $request)
  {
    if (!$this->getUser()->isAuthenticated())
      $this->forward('sfGuardAuth', 'secure');

    $ll_id = $request->getParameter('ll_id');

    $this->reviewed = Doctrine::getTable('LimelightReviewUser')->findByDql('user_id = ? AND limelight_id = ?', array($this->user->id, $ll_id));

    if (count($this->reviewed) == 0)
    {
      if ($request->isMethod('POST') && $request->hasParameter('title') && $request->hasParameter('content') && $request->hasParameter('scores'))
      {
        $nr = new LimelightReviewUser();
        $nr->title = strip_tags($request->getParameter('title'));
        $nr->content = str_replace("\n","<br>", strip_tags($request->getParameter('content'), '<a><br><p>'));
        $nr->limelight_id = $ll_id;
        $nr->user_id = $this->user->id;
        $nr->review_score = $request->getParameter('overall');
        $nr->save();
        $scores = json_decode($request->getParameter('scores'), true);
        foreach ($scores as $key => $score)
        {
          $sp = new LimelightReviewScoreParts();
          $sp->category_score_type_id = $key;
          $sp->review_id = $nr->id;
          $sp->score = $score;
          $sp->save();
        }

        $ll = Doctrine::getTable('Limelight')->findById($ll_id);
        $ll = $ll[0];
        $tempAverage = $ll->review_user_average * $ll->review_user_count;
        $tempAverage += $nr->review_score;
        $ll->review_user_count += 1;
        $ll->review_user_average = intval($tempAverage / $ll->review_user_count);
        $ll->save();
        
        $this->getUser()->setFlash('notice', 'Your review has been successfully submitted!');
        $this->renderText(LimelightUtils::buildLimelightURL('lime_reviews_show', $ll));
        return sfView::NONE;
      }
      else
      {
        $ll_id = $request->getParameter('ll_id');
        $this->formInfo = Doctrine::getTable('Limelight')->getLimelightUserReviewInfo($ll_id);
        $this->formInfo = $this->formInfo[0];
        $this->scorePartsAverage = Doctrine::getTable('Limelight')->getLimelightScorePartsAverage($ll_id);
        $this->scorePartsAverage = $this->scorePartsAverage[0];
        $this->form = new LimelightReviewUserForm();
      }
      //unset($this->form[$this->form->getCSRFFieldName()]);
    }
  }

  public function executeUpdate($request)
  {
    if (!$this->getUser()->isAuthenticated())
      $this->forward('sfGuardAuth', 'secure');

    $id = $request->getParameter('id');
    $content = $request->getParameter('content');

    //if (strlen($content) <= 1) {
    //      $this->renderText('0');
    //      return sfView::NONE;
    //}

    $review = Doctrine::getTable('LimelightReviewUser')->findOneById($id);

    if ($review['user_id'] != $this->user->id)
      return sfView::NONE;

    $review->content = str_replace("\n","<br>", strip_tags(substr($content, 0, sfConfig::get('app_reviews_content_max_length')), '<a><br><p>'));
    $review->edited += 1;
    $review->save();

    $cacheManager = $this->getContext()->getViewCacheManager();
    if ($cacheManager) {
      //$cacheManager->remove('@sf_cache_partial?module=comment&action=_showComments&sf_cache_key=comments_'.$type.'_'.$id.'-*');
    }

    return sfView::NONE;
  }

  public function executeUpdateReviewUserScore($request)
  {
    if (!$this->getUser()->isAuthenticated())
      $this->forward('sfGuardAuth', 'secure');

    $target_user_id = $request->getParameter('target_user_id');
    $review_id = $request->getParameter('item_id');
    $direction = $request->getParameter('d');

    if ($this->user->id == $target_user_id)
      $this->forward404('You submitted this item. You may not score your own submissions.');

    $updated = Doctrine::getTable('LimelightReviewUserScores')->updateScore($review_id, $this->user->id, $target_user_id, $direction);

    if ($updated) {
      $cacheManager = $this->getContext()->getViewCacheManager();
      if ($cacheManager) {

      }
      $this->renderText($updated->score);
    } else
      $this->renderText('err');

    return sfView::NONE;
  }

  public function executeShowUserReviews($request)
  {
    $user = $this->getUser();
    if ($user->isAuthenticated())
      $user_id = $user->getGuardUser()->id;
    else
      $user_id = 0;

    if (!$request->hasParameter('ll_id') || !$request->hasParameter('o'))
      $this->forward404("We\'re sorry! There was a parameter error.");

    $ll_id = $request->getParameter('ll_id');
    $o = $request->getParameter('o');

    if ($request->hasParameter('s'))
      $section = $request->getParameter('s');
    else
      $section = null;

    $reviews = Doctrine::getTable('LimelightReviewUser')->getReviews($ll_id, $user_id, $o, $section);

    if (count($reviews) > 0)
      $this->renderComponent('reviews', 'userReviews', array('ll_id' => $ll_id, 'reviews' => $reviews, 'sf_cache_key' => 'll_id='.$ll_id.'&user_id='.$user_id));

    return sfView::NONE;
  }
}
