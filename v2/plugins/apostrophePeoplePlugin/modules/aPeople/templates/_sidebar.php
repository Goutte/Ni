<?php
  $current = isset($current) ? $sf_data->getRaw('current') : 'aPeople/index';
?>

<?php use_helper('a') ?>

<div class="a-ui a-subnav-wrapper clearfix">
	<div class="a-subnav-inner">

		<div class="a-subnav-section search">
		  <div class="a-search a-search-sidebar">
		    <form id="aPeopleSearchForm" class="a-ui a-search a-search-people" action="<?php echo url_for(aUrl::addParams($current, array("search" => false))) ?>" method="get">
		  		<div class="a-form-row"> <?php // div is for page validation ?>
		  			<label for="a-search-people-field" style="display:none;">Search</label><?php // label for accessibility ?>
            <?php echo $form['name']->render() ?>
						<?php if ($hasName): ?>
					    <?php echo link_to(__('Clear Search', null, 'apostrophe'), aUrl::addParams($current, array('search' => '')), array('class' => 'a-clear-search-button', 'id' => 'a-people-search-remove', 'title' => __('Clear Search', null, 'apostrophe'), )) ?>
						<?php else: ?>
		  				<input type="image" src="<?php echo image_path('/apostrophePlugin/images/a-special-blank.gif') ?>" class="submit a-search-submit" value="Search Pages" alt="Search" title="Search"/>
						<?php endif ?>
		  		</div>
		    </form>
		  </div>
		</div>

		<hr class="a-ui a-hr" />

		<div class="a-subnav-section">
	    <form id="aPeopleCategoryForm" class="a-ui a-people-category-form" action="<?php echo url_for(aUrl::addParams($current, array("categories" => false))) ?>" method="get">
				<div class="a-form-row categories" id="aPeople-categories">
					<?php echo $form['categories']->renderLabel('Categories') ?>
					<div class="a-form-field">
						<?php echo $form['categories']->render() ?>
					</div>
					<?php echo $form['categories']->renderError() ?>
				</div>
				<div class="a-form-row submit">
					<?php echo a_submit_button('Filter', array('big','a-people-filter')) ?>
				</div>
			</form>
		</div>

	</div>
</div>

<?php a_js_call('aMultipleSelect(?, ?)', '#aPeople-categories', array('choose-one' => a_('Choose Categories'))) ?>
<?php a_js_call('apostrophe.selfLabel(?)', array('selector' => '#aPeopleCategoryFilter_name', 'title' => a_('Search By Name'), 'focus' => false)) ?>