<?php


class ItemTagTable extends ItemTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('ItemTag');
    }
}