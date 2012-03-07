<?php if ($a_person->getHeadshotId()): ?>
  <?php include_component('aSlideshowSlot', 'slideshow', array(
  	'items' => array($a_person->getHeadshot()),
  	'id' => $a_person->getId().'-headshot',
  	'options' => array('width' => 68, 'height' => 80, 'flexHeight' => false, 'resizeType' => 'c'),
  )) ?>
<?php endif ?>
