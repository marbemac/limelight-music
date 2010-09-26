<?php


class SourceViewTable extends ViewTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('SourceView');
    }
}