<?php


class ItemTagScoreTable extends ScoreTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('ItemTagScore');
    }
}