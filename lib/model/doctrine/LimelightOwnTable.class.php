<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class LimelightOwnTable extends Doctrine_Table
{
  public function disown($item_id, $user_id)
  {
    $q = Doctrine_Query::create()
      ->select('item_id')
      ->from('LimelightOwn')
      ->where('item_id = ? AND user_id = ?', array($item_id, $user_id));

    $own = $q->fetchOne();
    $own->delete();
  }
}