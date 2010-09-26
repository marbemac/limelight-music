<?php

class LimelightReviewUserScoreTable extends ScoreTable
{
  public function updateScore($review_id, $user_id, $target_user_id, $direction) {
    // Check to see if the item has already been scored by this user, and that this user did not submit the item
    $q = Doctrine_Query::create()
        ->select('id')
        ->from('LimelightReviewUserScores')
        ->where('review_id = ? AND user_id = ?', array($review_id, $user_id));
    $result = $q->fetchOne();

    if ($result)
      return false;

    $scoreChange = ($direction == 'plus') ? 1 : -1;

    $rs = new LimelightReviewUserScores();
    $rs->review_id = $review_id;
    $rs->user_id = $user_id;
    $rs->target_user_id = $target_user_id;
    $rs->count = $scoreChange;
    $rs->save();

    $us = new UserScores();
    $us->user_id = $target_user_id;
    $us->rater_id = $user_id;
    $us->count = $scoreChange;
    $us->source = 'review';
    $us->save();

    $review = Doctrine::getTable('LimelightReviewUser')->findOneById($review_id);
    $review->score += $scoreChange;
    $review->User->Profile->score += $scoreChange;
    $review->save();
    $review->User->Profile->save();

    return $review;
  }
}