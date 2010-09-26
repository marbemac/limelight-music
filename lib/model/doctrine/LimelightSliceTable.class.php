<?php


class LimelightSliceTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('LimelightSlice');
    }

    public function checkDuplicate($ll_id, $name)
    {
      $q = Doctrine_Query::create()
        ->select('id')
        ->from('LimelightSlice')
        ->where('item_id = ? AND name_slug = ?', array($ll_id, LimelightUtils::slugify($name)));

      return ($q->fetchOne() ? true : false);
    }
}