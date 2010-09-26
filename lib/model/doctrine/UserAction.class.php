<?php

/**
 * UserAction
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class UserAction extends BaseUserAction
{
  public function postInsert($event)
  {
    $cacheDriver = $this->getTable()->getAttribute(Doctrine_Core::ATTR_RESULT_CACHE);
    $cacheDriver->deleteByPrefix('user_'.$this->user_id.'_minifeed_');
  }
}