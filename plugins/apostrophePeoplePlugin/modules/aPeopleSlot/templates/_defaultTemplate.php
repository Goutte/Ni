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

<?php foreach ($people as $person): ?>
<div id="a-person-<?php echo $person->getId() ?>" class="a-person default">
	<p class="name">
	  <?php $slug = $person->getEngineSlug() ?>
		<?php echo link_to_if(strlen($slug), $person->getName(), 'aPeople_show', array('slug' => $person->getSlug(), 'engine-slug' => $slug)) ?>
  </p>
</div>
<?php endforeach ?>

