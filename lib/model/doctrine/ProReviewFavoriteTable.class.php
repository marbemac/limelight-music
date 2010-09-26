<?php


class ProReviewFavoriteTable extends FavoriteTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('ProReviewFavorite');
    }
}