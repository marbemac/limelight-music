<?php
class wikiComponents extends sfComponents
{
  // get the limelights that share a specific segment
  public function executeSegmentShared()
  {
    $this->shared = Doctrine::getTable('Wiki')->getLimelights($this->revision['group_id']);
  }
}