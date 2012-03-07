<div id="person-<?php echo $person->id ?>" class="person clearfix">
  <h4 class="name clearfix">
    <a class="person-expand-toggle" href="<?php echo url_for('aPeople_showPreview', array('slug' => $person->slug)) ?>" onclick="return false"><?php echo $person->getNameAndSuffix() ?></a>
    <div class="person-info"></div>
  </h4>

  <div class="person-info clearfix"></div>
	<div class="person-info-expanded clearfix">
		<?php // Do Not Remove :: Ajax outputs HTML to this container ?>
	</div>
</div>
