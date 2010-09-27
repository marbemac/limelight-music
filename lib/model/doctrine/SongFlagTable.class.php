<?php


class SongFlagTable extends FlagTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('SongFlag');
    }
}