<?php


class SongFavoriteTable extends FavoriteTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('SongFavorite');
    }
}