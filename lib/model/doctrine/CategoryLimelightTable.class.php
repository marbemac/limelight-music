<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class CategoryLimelightTable extends Doctrine_Table
{
  public function getLimelightCategories($ll_id)
  {
    $q = Doctrine_Query::create()
        ->select('cl.*, c.*')
        ->from('CategoryLimelight cl')
        ->leftJoin('cl.Category c')
        ->where('cl.limelight_id = ?', $ll_id);
    $result = $q->fetchArray();

    return $result;
  }
}