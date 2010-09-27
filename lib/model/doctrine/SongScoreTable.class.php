<?php


class SongScoreTable extends ScoreTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('SongScore');
    }
}