<?php


class LimelightSpecificationScoreTable extends ScoreTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('LimelightSpecificationScore');
    }
}