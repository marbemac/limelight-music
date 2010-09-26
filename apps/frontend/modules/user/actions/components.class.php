<?php
 
class userComponents extends sfComponents
{
  public function executeUserLink()
  {
    $user = Doctrine::getTable('sfGuardUser')->getUser($this->user_id);
    $this->user = $user;
    $this->username = $user['username'];
    $this->user_id = $user['id'];
    $this->score = $user['Profile']['score'];

    $this->scoreClass = ($this->score < 0) ? 'neg' : 'pos';
  }

  public function executeTopUsers()
  {
    $this->users1 = Doctrine::getTable('sfGuardUser')->getTopUsers(sfConfig::get('app_topusers_limit'), 1);
    $this->users7 = Doctrine::getTable('sfGuardUser')->getTopUsers(sfConfig::get('app_topusers_limit'), 7);
    $this->users30 = Doctrine::getTable('sfGuardUser')->getTopUsers(sfConfig::get('app_topusers_limit'), 30);
    $this->users0 = Doctrine::getTable('sfGuardUser')->getTopUsers(sfConfig::get('app_topusers_limit'), 0);
  }

  public function executeTopModUsers()
  {
    $this->users1 = Doctrine::getTable('sfGuardUser')->getTopModUsers(sfConfig::get('app_topmodusers_limit'), 1);
    $this->users7 = Doctrine::getTable('sfGuardUser')->getTopModUsers(sfConfig::get('app_topmodusers_limit'), 7);
    $this->users30 = Doctrine::getTable('sfGuardUser')->getTopModUsers(sfConfig::get('app_topmodusers_limit'), 30);
    $this->users0 = Doctrine::getTable('sfGuardUser')->getTopModUsers(sfConfig::get('app_topmodusers_limit'), 0);
  }

  public function executeProfileCard()
  {
    $this->following = Doctrine::getTable('FollowUserReference')->getUserData($this->user['id']);
    $this->badgeLevels = Doctrine::getTable('UserBadge')->getUserBadgeLevels($this->user['id']);;
  }

  public function executeNotifications()
  {
    $this->notifications = Doctrine::getTable('UserNotification')->getNotifications($this->user->id);
  }
} 