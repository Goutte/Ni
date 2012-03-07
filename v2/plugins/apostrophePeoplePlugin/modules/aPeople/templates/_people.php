<?php use_helper('a') ?>

<?php foreach ($people as $person): ?>
	<?php include_partial('aPeople/person', array('person' => $person)) ?>
<?php endforeach ?>