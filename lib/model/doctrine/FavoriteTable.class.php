<?php

class FavoriteTable extends Doctrine_Table
{
  public function unFavorite($user_id, $item_id, $table)
  {
    $deleted = Doctrine_Query::create()
      ->delete()
      ->from($table)
      ->where('user_id = ? AND item_id = ?', array($user_id, $item_id))
      ->execute();

    return $deleted;
  }

  public function checkFavorite($user_id, $item_id, $table)
  {
    $q = Doctrine_Query::create()
      ->select('id')
      ->from($table)
      ->where('user_id = ? AND item_id = ?', array($user_id, $item_id));

    return $q->fetchOne();
  }

  public function getUserFavoriteFeed($user_id, $limit, $offset, $order_by, $type) {
    $q = Doctrine_Query::create()
        ->select('f.item_id, f.created_at, i.id, i.created_at, i.score, i.total_views');

    if ($type == 'song')
      $q->addSelect('i.total_plays');

    $q->from(ucfirst($type).'Favorite f');

    $q->leftJoin('f.Item i');

    $q->where('f.user_id = ?', $user_id);

    if ($order_by == 'favorite_date')
      $q->orderBy('f.created_at DESC');
    else if ($order_by == 'submit_date')
      $q->orderBy('i.created_at DESC');
    else if ($order_by == 'score')
      $q->orderBy('i.score DESC');
    else if ($order_by == 'views')
      $q->orderBy('i.total_views DESC');
    else if ($order_by == 'plays')
      $q->orderBy('i.total_plays DESC');

    $q->limit($limit)
      ->offset($offset);
    
    $q->useResultCache(true, 3600, 'user_'.$user_id.'_favorited_'.$type.'_'.$order_by.'_'.$limit.'_'.$offset);
    return $q->fetchArray();
  }
}