<?php // OBSOLETE, see the new standardArea component at plugin level, which takes this idea a lot farther. Kept for bc ?>

<?php // Reasonable Defaults ?>
<?php $name = isset($name) ? $sf_data->getRaw('name') : 'body'; ?>
<?php $width = isset($width) ? $sf_data->getRaw('width') : 480; ?>
<?php $height = isset($height) ? $sf_data->getRaw('height') : false ?>
<?php $toolbar = isset($toolbar) ? $sf_data->getRaw('toolbar') : 'Sidebar'; ?>

<?php // Array of core slots we enable ?>
<?php $slots = isset($slots) ? $sf_data->getRaw('slots') : array(
  'aRichText', 
  'aVideo', 
  'aSlideshow', 
  'aSmartSlideshow', 
  'aFile', 
  'aAudio', 
  'aButton', 
  'aBlog', 
  'aEvent', 
  'aFeed', 
  // 'aText', 
  // 'aRawHTML'
); ?>

<?php // $areaOptions array is merged below. $areaOptions with matching keys win over what is below ?>
<?php $areaOptions = isset($areaOptions) ? $sf_data->getRaw('areaOptions') : array() ?>

<?php // $slotOptions['slotType'] array overrides the defaults if it is set ?>
<?php $slotOptions = isset($slotOptions) ? $sf_data->getRaw('slotOptions') : array() ?>

<?php a_area($name, array_merge(array(
  'areaHideWhenEmpty' => true,
	'allowed_types' => $slots,
  'type_options' => array(
		'aRichText' => isset($slotOptions['aRichText']) ? $slotOptions['aRichText'] : array(
		  'tool' => $toolbar,
			// 'allowed-tags' => array(),
			// 'allowed-attributes' => array('a' => array('href', 'name', 'target'),'img' => array('src')),
			// 'allowed-styles' => array('color','font-weight','font-style'),
		),
		'aVideo' => isset($slotOptions['aVideo']) ? $slotOptions['aVideo'] : array(
			'width' => $width,
			'height' => false,
			'resizeType' => 's',
			'flexHeight' => true,
			'title' => false,
			'description' => false,
		),
		'aSlideshow' => isset($slotOptions['aSlideshow']) ? $slotOptions['aSlideshow'] : array(
			'width' => $width,
			'height' => $height,
			'resizeType' => $height ? 'c' : 's',
			'flexHeight' => $height ? false : true,
			'constraints' => array('minimum-width' => $width, 'minimum-height' => $height),
			'arrows' => true,
			'interval' => false,
			'random' => false,
			'title' => false,
			'description' => false,
			'credit' => false,
			'position' => false,
			'itemTemplate' => 'slideshowItem',
			'allowed_variants' => array('normal','autoplay'), 
		),
		'aSmartSlideshow' => isset($slotOptions['aSmartSlideshow']) ? $slotOptions['aSmartSlideshow'] : array(
			'width' => $width,
			'height' => false,
			'resizeType' => $height ? 'c' : 's',
			'flexHeight' => $height ? false : true,
			'constraints' => array('minimum-width' => $width, 'minimum-height' => $height),
			'arrows' => true,
			'interval' => false,
			'random' => false,
			'title' => false,
			'description' => false,
			'credit' => false,
			'position' => false,
			'itemTemplate' => 'slideshowItem',
		),
		'aFile' => isset($slotOptions['aFile']) ? $slotOptions['aFile'] : array(
		),
		'aAudio' => isset($slotOptions['aAudio']) ? $slotOptions['aAudio'] : array(
			'width' => $width,
			'title' => true,
			'description' => true,
			'download' => true,
			'playerTemplate' => 'default',
		),
		'aFeed' => isset($slotOptions['aFeed']) ? $slotOptions['aFeed'] : array(
			'posts' => 5,
			'links' => true,
			'dateFormat' => false,
			'itemTemplate' => 'aFeedItem',
			// 'markup' => '<strong><em><p><br><ul><li><a>',
			// 'attributes' => false,
			// 'styles' => false,
		),
		'aButton' => isset($slotOptions['aButton']) ? $slotOptions['aButton'] : array(
			'width' => $width,
			'flexHeight' => true,
			'resizeType' => 's',
			'constraints' => array('minimum-width' => $width, 'minimum-height' => $height),
			'rollover' => true,
			'title' => true,
			'description' => false
		),
		'aBlog' => isset($slotOptions['aBlog']) ? $slotOptions['aBlog'] : array(
			// 'excerptLength' => 100, 
			// 'aBlogMeta' => true,
			// 'maxImages' => 1, 
			'slideshowOptions' => array(
				'width' => $width,
				'height' => false
			),
		),
		'aEvent' => isset($slotOptions['aEvent']) ? $slotOptions['aEvent'] : array(
			// 'excerptLength' => 100, 
			// 'aBlogMeta' => true,
			// 'maxImages' => 1, 
			'slideshowOptions' => array(
				'width' => $width,
				'height' => false
			),
		),
    'aText' => isset($slotOptions['aText']) ? $slotOptions['aText'] : array(
			'multiline' => false
		),
		'aRawHTML' => isset($slotOptions['aRawHTML']) ? $slotOptions['aRawHTML'] : array(
		),
)), $areaOptions)) ?>