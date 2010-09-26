<?php


class LimelightSpecificationTable extends ItemTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('LimelightSpecification');
    }

    public function checkDuplicate($ll_id, $name, $content)
    {
      $q = Doctrine_Query::create()
        ->select('ls.id as ls_id, s.id as s_id')
        ->from('LimelightSpecification ls')
        ->leftJoin('ls.Specification s')
        ->where('ls.item_id = ? AND ls.content_slug = ? AND s.name_slug = ?', array($ll_id, LimelightUtils::slugify($content), LimelightUtils::slugify($name)));

      return ($q->fetchOne() ? true : false);
    }

    
}