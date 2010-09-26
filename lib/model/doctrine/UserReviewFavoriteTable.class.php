<?php


class UserReviewFavoriteTable extends FavoriteTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('UserReviewFavorite');
    }
}