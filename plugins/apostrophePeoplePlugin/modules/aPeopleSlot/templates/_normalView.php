<?php
  // Compatible with sf_escaping_strategy: true
  $dimensions = isset($dimensions) ? $sf_data->getRaw('dimensions') : null;
  $editable = isset($editable) ? $sf_data->getRaw('editable') : null;
  $item = isset($item) ? $sf_data->getRaw('item') : null;
  $itemId = isset($itemId) ? $sf_data->getRaw('itemId') : null;
  $name = isset($name) ? $sf_data->getRaw('name') : null;
  $options = isset($options) ? $sf_data->getRaw('options') : null;
  $page = isset($page) ? $sf_data->getRaw('page') : null;
  $pageid = isset($pageid) ? $sf_data->getRaw('pageid') : null;
  $permid = isset($permid) ? $sf_data->getRaw('permid') : null;
  $slot = isset($slot) ? $sf_data->getRaw('slot') : null;
  $slug = isset($slug) ? $sf_data->getRaw('slug') : null;
?>
<?php use_helper('a') ?>

<?php if ($editable): ?>
	<?php slot("a-slot-controls-$pageid-$name-$permid") ?>
			<?php include_partial('a/simpleEditWithVariants', array('pageid' => $pageid, 'name' => $name, 'permid' => $permid, 'slot' => $slot, 'page' => $page, 'controlsSlot' => false, 'label' => a_get_option($options, 'editLabel', a_('Edit')))) ?>
	<?php end_slot() ?>
<?php endif ?>
<?php if ($people): ?>
		<?php include_partial('aPeopleSlot/'.$options['itemTemplate'].'Template', array(
			'dimensions' => $dimensions, 
			'constraints' => $options['constraints'], 
			'editable' => $editable, 
			'item' => $item, 
			'itemId' => $itemId, 
			'name' => $name, 
			'options' => $options, 
			'page' => $page, 
			'pageid' => $pageid,
			'permid' => $permid,
			'slot' => $slot, 
			'slug' => $slug,
			'people' => $people, 
		)) ?>
<?php else: ?>
  
<p>Click the edit button above to choose people for this slot.</p>

<?php endif ?>
