<?php

class LimelightProConScoreTable extends ScoreTable
{
  public function updateScore($procon_id, $user_id, $target_user_id, $direction) {
    // Check to see if the item has already been scored by this user, and that this user did not submit the item
    $q = Doctrine_Query::create()
        ->select('amount')
        ->from('LimelightProConScore')
        ->where('limelightprocon_id = ? AND user_id = ?', array($procon_id, $user_id));
    $result = $q->fetchOne();

    if ($result)
      return false;

    $scoreChange = ($direction == 'plus') ? 1 : -1;

    $date = date('Y-m-d', time());

    $pc = new LimelightProConScore();
    $pc->limelightprocon_id = $procon_id;
    $pc->user_id = $user_id;
    $pc->target_user_id = $target_user_id;
    $pc->amount = $scoreChange;
    $pc->save();

    return $pc->Item;
  }
}