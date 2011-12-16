<?php
class BaseaPeopleSlotComponents extends aSlotComponents
{

  protected function setupOptions()
	{
    $this->options['constraints'] = $this->getOption('constraints', array());
    $this->options['width'] = $this->getOption('width', 160);
    $this->options['height'] = $this->getOption('height', false);
    $this->options['resizeType'] = $this->getOption('resizeType', 's');
    $this->options['flexHeight'] = $this->getOption('flexHeight', true);
		$this->options['itemTemplate'] = $this->getOption('itemTemplate', 'default');		
		$this->options['image'] = $this->getOption('image', true);
	}
	
	public function executeEditView()
  {
    // Must be at the start of both view components
    $this->setup();
    $this->setupOptions();
    // Careful, don't clobber a form object provided to us with validation errors
    // from an earlier pass
    if (!isset($this->form))
    {
      $this->form = new aPeopleSlotEditForm($this->id, $this->slot->getArrayValue());
    }
  }

  public function executeNormalView()
  {
    $this->setup();
    $this->setupOptions();
    $this->values = $this->slot->getArrayValue();
    $this->options['slideshowOptions']['width']	= ((isset($this->options['slideshowOptions']['width']))? $this->options['slideshowOptions']['width']:100);
		$this->options['slideshowOptions']['height'] = ((isset($this->options['slideshowOptions']['height']))? $this->options['slideshowOptions']['height']:100);
		$this->options['slideshowOptions']['resizeType'] = ((isset($this->options['slideshowOptions']['resizeType']))? $this->options['slideshowOptions']['resizeType']:'c');
		$this->people = false;
    if ($this->values)
    {
      $this->people = Doctrine::getTable('aPerson')
        ->createQuery()
        ->whereIn('id', $this->values['people'])
				->orderBy('last_name ASC')
        ->execute();
    }
  }
}
