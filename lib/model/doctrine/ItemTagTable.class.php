<?php


class ItemTagTable extends ItemTable
{
  public function checkTag($tag_id, $item_id, $item_type)
  {
    $q = Doctrine_Query::create()
        ->select('id')
        ->from('ItemTag')
        ->where('tag_id = ? AND item_id = ? AND type = ?', array($tag_id, $news_id, $item_type));

    $result = $q->fetchOne();

    if (!$result)
      return false;
    else
      return true;
  }

  public function getTags($item_id, $item_type) {
    $q = Doctrine_Query::create()
        ->select('t.*, it.*')
        ->from('Tag t')
        ->leftJoin('t.ItemTags it')
        ->where('t.status = ? AND it.item_id = ? AND it.status = ? AND it.type = ?', array('Active', $item_id, 'Active', $item_type))
        ->orderBy('it.score DESC')
        ->useResultCache(true, 3600, 'item_tags_'.$item_type.'_'.$item_id);

    return $q->fetchArray();
  }

  public function getTag($tag_id, $user_id) {
    $q = Doctrine_Query::create()
        ->select('t.id, ts.amount, ts.id AS scored')
        ->from('ItemTag t')
        ->leftJoin('t.Scores ts WITH ts.user_id = ?', $user_id)
        ->where('t.id = ?', $tag_id);

    return $q->fetchOne();
  }
}