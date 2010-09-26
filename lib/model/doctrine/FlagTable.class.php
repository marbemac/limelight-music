<?php

class FlagTable extends Doctrine_Table
{
  public function checkFlagged($item_type, $item_id, $user_id) {
    $q = Doctrine_Query::create()
        ->select('id, item_id, created_at')
        ->from($item_type)
        ->where('item_id = ? AND user_id = ?', array($item_id, $user_id));
    return $q->fetchOne();
  }

  public function flag($user_id, $item_id, $item_type, $flag_type) {
    // Check to see if the item has already been flagged by this user
    $q = Doctrine_Query::create()
        ->select('f.id, f.created_at, f.type')
        ->from($item_type.'Flag f')
        ->where('f.user_id = ? AND f.item_id = ?', array($user_id, $item_id));
    $result = $q->fetchOne();

    if ($result)
      return $result;

    $class = $item_type.'Flag';
    $f = new $class();
    $f->type = $flag_type;
    $f->user_id = $user_id;
    $f->item_id = $item_id;
    $f->save();

    return false;
  }

  // reduce the limelight score when an item that contributed to its score has been flagged
  public function reduceLimelightScore($item_type, $item_id, $ll_id)
  {
    $q = Doctrine_Query::create()
        ->select('id, SUM(amount) score')
        ->from('LimelightScore')
        ->where('type = ? AND contributing_item_id = ? AND item_id = ?', array($item_type, $item_id, $ll_id));
    $result = $q->fetchOne();

    if ($result != null && $result['score'] != 0)
    {
      $q = Doctrine_Query::create()
          ->update('Limelight')
          ->set('score', 'score - ' . $result['score'])
          ->where('id = ?', $ll_id);
      $q->execute();

      // flag the specific limelight scores
      Doctrine::getTable('LimelightScore')->flagScores($item_type, $item_id, $ll_id);
    }
  }
}