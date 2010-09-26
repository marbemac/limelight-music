<?php

/**
 * View
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class View extends BaseView
{
  public function postSave($event) {
    $item = $this->Item;
    $user_id = isset($this->target_user_id) ? $this->target_user_id : $this->user_id;
    $total_views = (get_class($this) == 'UserView') ? $item->Profile->total_views : $item->total_views;
    if ($total_views == sfConfig::get('app_badge_'.get_class($this).'_min'))
      Doctrine::getTable('Badge')->increaseBadgeStat(sfConfig::get('app_badge_'.get_class($this).'_add'), $user_id);
    else if ($total_views == sfConfig::get('app_badge_'.get_class($this).'_level2_min'))
      Doctrine::getTable('Badge')->increaseBadgeStat(sfConfig::get('app_badge_'.get_class($this).'_level2_add'), $user_id);
  }
}