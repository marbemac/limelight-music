<?php


class PlaylistScoreTable extends ScoreTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('PlaylistScore');
    }
}