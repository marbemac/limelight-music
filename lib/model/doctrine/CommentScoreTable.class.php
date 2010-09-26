<?php

class CommentScoreTable extends ScoreTable
{
  public function updateScore($comment_id, $user_id, $target_user_id, $direction) {
    // Check to see if the item has already been scored by this user, and that this user did not submit the item
    $q = Doctrine_Query::create()
        ->select('count')
        ->from('CommentScores')
        ->where('comment_id = ? AND user_id = ?', array($comment_id, $user_id));
    $result = $q->fetchOne();

    if ($result)
      return false;

    $scoreChange = ($direction == 'plus') ? 1 : -1;

    $date = date('Y-m-d', time());

    $is = new CommentScores();
    $is->comment_id = $comment_id;
    $is->user_id = $user_id;
    $is->target_user_id = $target_user_id;
    $is->count = $scoreChange;
    $is->save();

    $us = new UserScores();
    $us->user_id = $target_user_id;
    $us->rater_id = $user_id;
    $us->count = $scoreChange;
    $us->save();

    $comment = Doctrine::getTable('Comment')->findOneById($comment_id);
    $comment->score += $scoreChange;
    $comment->User->Profile->score += $scoreChange;
    $comment->save();
    $comment->User->Profile->save();

    return $comment;
  }
}