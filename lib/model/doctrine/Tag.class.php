<?php

/**
 * Tag
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class Tag extends BaseTag
{
  public function postInsert($event) {
    $cacheDriver = $this->getTable()->getAttribute(Doctrine_Core::ATTR_RESULT_CACHE);
    $cacheDriver->delete('tag_list');
  }
}