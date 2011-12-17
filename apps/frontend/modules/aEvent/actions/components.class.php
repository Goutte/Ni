<?php
/**
 * aEvent Components.
 * 
 * @package    apostropheBlogPlugin
 * @subpackage aEvent
 * @author     Dan Ordille <dan@punkave.com>
 */
class aEventComponents extends BaseaEventComponents
{
  public function executeSubNavConcerts ()
  {
    $this->concerts = aEventTable::getInstance()->findAll(Doctrine_Core::HYDRATE_RECORD);
  }
}
