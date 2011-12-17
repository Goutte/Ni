<?php
  // Compatible with sf_escaping_strategy: true
  $categories = isset($categories) ? $sf_data->getRaw('categories') : null;
  $authors = isset($authors) ? $sf_data->getRaw('authors') : null;
  $n = isset($n) ? $sf_data->getRaw('n') : null;
  $noFeed = isset($noFeed) ? $sf_data->getRaw('noFeed') : null;
  $params = isset($params) ? $sf_data->getRaw('params') : null;
  $tagsByPopularity = isset($tagsByPopularity) ? $sf_data->getRaw('tagsByPopularity') : null;
  $tagsByName = isset($tagsByName) ? $sf_data->getRaw('tagsByName') : null;
	$url = isset($url) ? $sf_data->getRaw('url') : null;
	$searchLabel = isset($searchLabel) ? $sf_data->getRaw('searchLabel') : null;
	$newLabel = isset($newLabel) ? $sf_data->getRaw('newLabel') : null;
	$adminModule = isset($adminModule) ? $sf_data->getRaw('adminModule') : null;
  $calendar = isset($calendar) ? $sf_data->getRaw('calendar') : null;
  $tag = (!is_null($sf_params->get('tag'))) ? $sf_params->get('tag') : null;
	$selected = array('icon','a-selected','alt','icon-right'); // Class names for selected filters
?>

<?php // url_for is the LAST step after other addParams calls play with what we want to include. Don't do it now ?>

<?php // Do not jam year month and day into non-date filters when departing from an individual post ?>
<?php if ($sf_params->get('action') === 'show'): ?>
  <?php $filterUrl = aUrl::addParams($url, array('tag' => $sf_params->get('tag'), 'cat' => $sf_params->get('cat'), 'q' => $sf_params->get('q'), 'author' => $sf_params->get('author'))) ?>
<?php else: ?>
  <?php $filterUrl = aUrl::addParams($url, array('tag' => $sf_params->get('tag'), 'cat' => $sf_params->get('cat'), 'year' => $sf_params->get('year'), 'month' => $sf_params->get('month'), 'day' => $sf_params->get('day'), 'q' => $sf_params->get('q'), 'author' => $sf_params->get('author'))) ?>
<?php endif ?>


<?php if (aBlogItemTable::userCanPost()): ?>
	<div class="a-ui clearfix a-subnav-section a-sidebar-button-wrapper">
	  <?php echo a_js_button($newLabel, array('big', 'a-add', 'a-blog-new-post-button', 'a-sidebar-button'), 'a-blog-new-post-button') ?>
    <div class="a-ui a-options a-blog-admin-new-ajax dropshadow">
      <?php include_component($newModule, $newComponent) ?>
    </div>
	</div>
<?php endif ?>

<?php //a_js_call('aBlog.sidebarEnhancements(?)', array()) ?>