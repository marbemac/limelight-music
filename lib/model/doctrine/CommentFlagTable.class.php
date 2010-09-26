<?php

class CommentFlagTable extends FlagTable
{
  public function flagComment($user_id, $comment_id, $flag_type)
  {
    $date = date('Y-m-d', time());

    // Check to see if the item has already been flagged by this user
    $q = Doctrine_Query::create()
        ->select('id')
        ->from('CommentFlags')
        ->where('comment_id = ? AND user_id = ?', array($comment_id, $user_id));
    $result = $q->fetchOne();

    if ($result)
      return false;

    $fc = new CommentFlags();
    $fc->flag_type = $flag_type;
    $fc->user_id = $user_id;
    $fc->comment_id = $comment_id;
    $fc->save();

    $q = Doctrine_Query::create()
        ->select('count(id) AS flag_count')
        ->from('CommentFlags')
        ->where('comment_id = ? AND flag_type = ?', array($comment_id, $flag_type));
    $result = $q->fetchOne();

    if($result['flag_count'] >= sfConfig::get('app_comment_flag_val')) {
      $fc->Comment->status = 'Flagged';
      $fc->Comment->save();
    }

    return true;
  }
}