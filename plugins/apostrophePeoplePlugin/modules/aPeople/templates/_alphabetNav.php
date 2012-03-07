<ul class="alphabet-navigation clearfix">
  <?php foreach ($navChars as $char => $people): ?>
		<?php if (count($people)): ?>
      <?php if ($anchorNavigation): ?>
  			<li><a href="#<?php echo $char ?>"><?php echo $char; ?></a></li>
      <?php else: ?>
  			<li><?php echo link_to($char, 'aPeople_char', array('char' => $char), array('class' => ($char == $sf_params->get('char')) ? 'active' : '')) ?></a></li>
      <?php endif ?>
		<?php else: ?>
			<li><span><?php echo $char; ?></span></li>
		<?php endif ?>
	<?php endforeach ?>
</ul>
