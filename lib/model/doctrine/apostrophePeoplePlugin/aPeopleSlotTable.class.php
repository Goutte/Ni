<?php

/**
 * aPeopleSlotTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class aPeopleSlotTable extends PluginaPeopleSlotTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object aPeopleSlotTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('aPeopleSlot');
    }
}