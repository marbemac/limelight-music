<?php

/**
 * Source
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Source extends BaseSource
{
  public function postInsert($event) {
    $cacheDriver = $this->getTable()->getAttribute(Doctrine_Core::ATTR_RESULT_CACHE);
    $cacheDriver->delete('sources');
  }
}