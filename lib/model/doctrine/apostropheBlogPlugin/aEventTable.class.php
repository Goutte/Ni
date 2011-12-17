<?php


class aEventTable extends PluginaEventTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('aEvent');
    }

    public function findAllPublished()
    {
       $q = $this->createQuery('dctrn_find');
       $this->addPublished($q);
       return $q->execute(array());
    }

}