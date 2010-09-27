<?php


class ItemTagFlagTable extends FlagTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('ItemTagFlag');
    }
}