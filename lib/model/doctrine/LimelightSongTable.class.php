<?php


class LimelightSongTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('LimelightSong');
    }
}