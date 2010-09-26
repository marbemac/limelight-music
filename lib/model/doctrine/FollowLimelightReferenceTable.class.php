<?php


class FollowLimelightReferenceTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('FollowLimelightReference');
    }

    public function checkFollowing($user_id, $ll_id)
    {
      $q = Doctrine_Query::create()
        ->select('user_id, limelight_id')
        ->from('FollowLimelightReference')
        ->where('user_id = ? AND limelight_id = ?', array($user_id, $ll_id))
        ->useResultCache(true, 262080, 'limelight_follow_'.$user_id.'_'.$ll_id);
      $result = $q->fetchOne();
      return $result;
    }

    public function stopFollowing($user_id, $ll_id)
    {
      $deleted = Doctrine_Query::create()
        ->delete()
        ->from('FollowLimelightReference')
        ->where('user_id = ? AND limelight_id = ?', array($user_id, $ll_id))
        ->execute();

      $cacheDriver = $this->getAttribute(Doctrine_Core::ATTR_RESULT_CACHE);
      $cacheDriver->delete('limelight_follow_'.$user_id.'_'.$ll_id);
      $cacheDriver->delete('user_'.$user_id.'_limelight_following');

//      Doctrine::getTable('Badge')->decreaseBadgeStat('Sheep', $user1_id);
//      Doctrine::getTable('Badge')->decreaseBadgeStat('King', $user2_id);

      return $deleted;
    }

    // get the following data for a user
    public function getUserData($user_id)
    {
      $data = array();
      $q = Doctrine_Query::create()
        ->select('user_id, limelight_id')
        ->from('FollowLimelightReference')
        ->where('user_id = ?', array($user_id))
        ->useResultCache(true, 300, 'limelight_following_'.$user_id);
      $result = $q->fetchArray();

      $data['Following'] = $result;

      return $data;
    }
}