<?php


class LimelightSummaryTable extends ItemTable
{
    
  public static function getInstance()
  {
      return Doctrine_Core::getTable('LimelightSummary');
  }

  // find and return the next available version number
  public function generateVersionNum($ll_id)
  {
    $q = Doctrine_Query::create()
        ->select('id, version')
        ->from('LimelightSummary')
        ->where('item_id = ?', $ll_id)
        ->orderBy('version DESC');
    $result = $q->fetchOne();
    return $result['version'] + 1;
  }
}