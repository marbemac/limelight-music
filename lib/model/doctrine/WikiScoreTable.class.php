<?php


class WikiScoreTable extends ScoreTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('WikiScore');
    }
}