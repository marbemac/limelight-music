<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class NewsTagTable extends ItemTable
{
  public function checkTag($tag_id, $news_id)
  {
    $q = Doctrine_Query::create()
        ->select('id')
        ->from('NewsTag')
        ->where('tag_id = ? AND item_id = ?', array($tag_id, $news_id));

    $result = $q->fetchOne();

    if (!$result)
      return false;
    else
      return true;
  }

  public function getTags($news_id) {
    $q = Doctrine_Query::create()
        ->select('t.*, nt.*')
        ->from('Tag t')
        ->leftJoin('t.NewsTags nt')
        ->where('t.status = ? AND nt.item_id = ? AND nt.status = ?', array('Active', $news_id, 'Active'))
        ->orderBy('nt.score DESC')
        ->useResultCache(true, 3600, 'news_tags_'.$news_id);

    return $q->fetchArray();
  }

  public function getTag($tag_id, $user_id) {
    $q = Doctrine_Query::create()
        ->select('t.id, ts.amount, ts.id AS scored')
        ->from('NewsTag t')
        ->leftJoin('t.Scores ts WITH ts.user_id = ?', $user_id)
        ->where('t.id = ?', $tag_id);

    return $q->fetchOne();
  }
}