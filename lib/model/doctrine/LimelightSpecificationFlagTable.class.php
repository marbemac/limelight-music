<?php


class LimelightSpecificationFlagTable extends FlagTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('LimelightSpecificationFlag');
    }
}