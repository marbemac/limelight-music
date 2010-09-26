<?php


class FollowUserReferenceTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('FollowUserReference');
    }

    public function checkFollowing($user1_id, $user2_id)
    {
      $q = Doctrine_Query::create()
        ->select('user1_id, user2_id')
        ->from('FollowUserReference')
        ->where('user1_id = ? AND user2_id = ?', array($user1_id, $user2_id))
        ->useResultCache(true, 262080, 'user_follow_'.$user1_id.'_'.$user2_id);
      $result = $q->fetchOne();
      return $result;
    }

    public function stopFollowing($user1_id, $user2_id)
    {
      $deleted = Doctrine_Query::create()
        ->delete()
        ->from('FollowUserReference')
        ->where('user1_id = ? AND user2_id = ?', array($user1_id, $user2_id))
        ->execute();

      $cacheDriver = $this->getAttribute(Doctrine_Core::ATTR_RESULT_CACHE);
      $cacheDriver->delete('user_follow_'.$user1_id.'_'.$user2_id);
      $cacheDriver->delete('user_'.$user1_id.'_user_following');

      Doctrine::getTable('Badge')->decreaseBadgeStat('Sheep', $user1_id);
      Doctrine::getTable('Badge')->decreaseBadgeStat('King', $user2_id);

      return $deleted;
    }

    // get the following data for a user
    public function getUserData($user_id)
    {
      $data = array();
      $q = Doctrine_Query::create()
        ->select('user1_id, user2_id')
        ->from('FollowUserReference')
        ->where('user1_id = ?', array($user_id))
        ->useResultCache(true, 300, 'user_following_'.$user_id);
      $result = $q->fetchArray();

      $data['Following'] = $result;

      $q = Doctrine_Query::create()
        ->select('user1_id, user2_id')
        ->from('FollowUserReference')
        ->where('user2_id = ?', array($user_id))
        ->useResultCache(true, 300, 'user_followers_'.$user_id);
      $result = $q->fetchArray();

      $data['Followers'] = $result;

      return $data;
    }
}