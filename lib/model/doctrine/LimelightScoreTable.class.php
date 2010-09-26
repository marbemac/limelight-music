<?php

class LimelightScoreTable extends Doctrine_Table
{
  // reduce the user score after an item that contributed to their score is flagged
  public function flagScores($item_type, $item_id, $limelight_id)
  {
    $q = Doctrine_Query::create()
        ->update('LimelightScore')
        ->set('status', '?', 'Flagged')
        ->where('type = ? AND contributing_item_id = ? AND item_id = ?', array($item_type, $item_id, $limelight_id))
        ->execute();
  }
}