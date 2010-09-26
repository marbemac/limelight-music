<?php


class WikiFlagTable extends FlagTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('WikiFlag');
    }
}