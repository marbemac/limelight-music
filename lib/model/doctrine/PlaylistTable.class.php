<?php


class PlaylistTable extends ItemTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Playlist');
    }
}