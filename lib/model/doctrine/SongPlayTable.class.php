<?php


class SongPlayTable extends PlayTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('SongPlay');
    }
}