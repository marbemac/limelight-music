<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class CommentTable extends ItemTable
{

  public function getComments($item_id, $comment_type) {
    $type_column = $comment_type.'_id';
    $q = Doctrine_Query::create()
        ->select('c.*, u.id, p.profile_image')
        ->from('Comment c')
        ->leftJoin('c.User u')
        ->leftJoin('u.Profile p')
        ->where('c.'.$type_column.' = ? AND c.status = ? AND c.type = ?', array($item_id, 'Active', $comment_type))
        ->orderBy('c.parent_id ASC')
        ->addOrderBy('c.created_at');
    $result = $q->fetchArray();

    return $result;
  }

  // get the comment item information for use in feeds (returns info for a single comment feed item)
  public function getForFeed($comment_id) {
    $q = Doctrine_Query::create()
        ->select('c.*, n.id, n.title title, n.title_slug title_slug')
        ->from('Comment c')
        ->leftJoin('c.News n')
        ->where('c.id = ?', $comment_id);
    $results = $q->fetchArray();
    return $results[0];
  }
}