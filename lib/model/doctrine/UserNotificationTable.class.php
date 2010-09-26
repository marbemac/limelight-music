<?php

class UserNotificationTable extends Doctrine_Table
{
  public function getNotifications($user_id) {
    $q = Doctrine_Query::create()
        ->select('*')
        ->from('UserNotification')
        ->where('user_id = ? AND is_read != ?', array($user_id, 1))
        ->orderBy('created_at DESC');
    $q->useResultCache(true, 3600, 'user_'.$user_id.'_notifications');
    return $q->execute();
  }

  public function markAllRead($user_id) {
    $q = Doctrine_Query::create()
        ->update('UserNotification')
        ->set('is_read', '?', true)
        ->where('user_id = ? AND is_read != ?', array($user_id, true))
        ->execute();

    $cacheDriver = $this->getAttribute(Doctrine_Core::ATTR_RESULT_CACHE);
    $cacheDriver->delete('user_'.$user_id.'_notifications');
  }

  public function markOneRead($user_id, $notification_id) {
    $q = Doctrine_Query::create()
        ->update('UserNotification')
        ->set('is_read', '?', true)
        ->where('user_id = ? AND id = ?', array($user_id, $notification_id))
        ->execute();

    $cacheDriver = $this->getAttribute(Doctrine_Core::ATTR_RESULT_CACHE);
    $cacheDriver->delete('user_'.$user_id.'_notifications');
  }
}