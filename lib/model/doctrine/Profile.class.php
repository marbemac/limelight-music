<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Profile extends BaseProfile
{
  public function  postSave($event) {
    // clear the user link
    $cacheDriver = $this->getTable()->getAttribute(Doctrine_Core::ATTR_RESULT_CACHE);
    $cacheDriver->delete('user_'.$this->sf_guard_user_id);
  }
}