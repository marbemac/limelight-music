<?php


class NewsLinkScoreTable extends ScoreTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('NewsLinkScore');
    }
}