<?php


class NewsTagFlagTable extends FlagTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('NewsTagFlag');
    }
}