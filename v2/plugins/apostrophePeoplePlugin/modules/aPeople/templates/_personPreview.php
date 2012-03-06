<?php if ($person->getHeadshotId()): ?>
	<div class="person-image">
	  <?php include_component('aSlideshowSlot', 'slideshow', array(
	  	'items' => array($person->getHeadshot()),
	  	'id' => $person->getId().'-headshot',
	  	'options' => array('width' => 100, 'height' => 120, 'resizeType' => 'c', 'arrows' => false, 'idSuffix' => 'personPreview'),
	  )) ?>
	</div>
<?php endif ?>
<div class="person-details">
	<?php if ($person->getBody()): ?>
	<div class="person-body clearfix">
	  <?php echo aHtml::limitWords(html_entity_decode($person->getBody()), 30) ?>
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
	<div class="person-jump clearfix">
			<?php echo link_to('More Info', url_for('aPeople_show', array('slug' => $person->slug)), array('class' => 'person-read-more')) ?>
	</div>
</div>
<?php include_partial('a/globalJavascripts') ?>