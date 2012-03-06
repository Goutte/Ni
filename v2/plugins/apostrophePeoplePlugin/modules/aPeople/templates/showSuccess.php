<?php
	$page = aTools::getCurrentPage();
	$editable = isset($editable) ? $sf_data->getRaw('editable') : null;
	$user = sfContext::getInstance()->getUser();
?>

<?php slot('body_class','a-people show') ?>

<?php slot('a-subnav') ?>
	<?php include_component('aPeople', 'sidebar') ?>
<?php end_slot() ?>

<?php if ($user->hasCredential('admin')): ?>
	<div class="a-ui edit-person">
			<?php echo link_to('<span class="icon"></span>edit','/admin/people/'.$person->getId().'/edit', array('class'=>'a-btn icon no-label a-edit')) ?>
	</div>
<?php endif ?>

<h2 class="person-name clearfix"><?php echo $person->getNameAndSuffix() ?></h2>

<?php if ($person->getHeadshotId()): ?>
	<div class="person-image">
	  <?php include_component('aSlideshowSlot', 'slideshow', array(
	  	'items' => array($person->getHeadshot()),
	  	'id' => $person->getId().'-headshot',
	  	'options' => array('width' => 200, 'height' => 240, 'resizeType' => 'c', 'arrows' => false)
	  )) ?>
	</div>
<?php endif ?>

<div class="person-details">
	<?php if ($person->getBody()): ?>
	<div class="person-body clearfix">
	  <?php echo html_entity_decode($person->getBody()) ?>
	</div>
	<?php endif ?>
	<?php if ($person->getLink()): ?>
	<div class="person-website clearfix">
	  <?php echo link_to('View Website', $person->getLink()) ?>
	</div>
	<?php endif ?>
	<?php if ($person->getEmail()): ?>
		<div class="email clearfix"><?php echo mail_to($person->getEmail(), $person->getEmail()) ?></div>
	<?php endif ?>
	</div>
</div>

