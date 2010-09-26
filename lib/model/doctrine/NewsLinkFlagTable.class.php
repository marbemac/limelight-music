<?php


class NewsLinkFlagTable extends FlagTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('NewsLinkFlag');
    }
}