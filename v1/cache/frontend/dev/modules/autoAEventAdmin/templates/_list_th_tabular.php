	<?php slot('a-admin.current-header') ?>
	<th class="a-admin-text a-column-title">
      <span class="a-simple-title"><?php echo __('Title', array(), 'messages') ?></span>
  
    
  <?php if ('title' == $sort[0]): ?>

		<?php ($sort[1] == 'asc')? $sortLabel = __('<span class="icon"></span>Descending', array(), 'a-admin'): $sortLabel = __('<span class="icon"></span>Ascending', array(), 'a-admin'); ?>

    <?php echo link_to(
			$sortLabel,
			'aEventAdmin/index?sort=title&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'), 
			array('class' => 'a-btn flag flag-right a-sort-arrow no-bg no-label icon alt sorting '.$sort[1].(($sort[1] == 'asc') ? ' a-arrow-up' : ' a-arrow-down'), 'title' => __($sortLabel, array(), 'a-admin'))) 
		?>
		
    <?php else: ?>

    <?php echo link_to(
      __('<span class="icon"></span>Ascending', array(), 'a-admin'),
      'aEventAdmin/index?sort=title&sort_type=asc', 
			array('class' => 'a-btn flag flag-right a-sort-arrow not-sorting no-bg no-label icon a-arrow-up alt asc', 'title' => __('Ascending', array(), 'a-admin')))
		?>
		
  <?php endif; ?>

  	</th>
	<?php end_slot(); ?>

<?php include_slot('a-admin.current-header') ?>
	<?php slot('a-admin.current-header') ?>
	<th class="a-admin-foreignkey a-column-author_id">
          <ul class="a-multi-title">
      <li><a href="#" class="a-btn a-sort-label alt"><?php echo __('Author', array(), 'messages') ?></a>
        <div class="filternav author_id">
          <hr/>
          <?php include_partial('aEventAdmin/list_th_dropdown', array('filters' => $filters, 'name' => 'author_id'  )) ?>    
            </div>
      </li>
    </ul>
  
    
  <?php if ('author_id' == $sort[0]): ?>

		<?php ($sort[1] == 'asc')? $sortLabel = __('<span class="icon"></span>Descending', array(), 'a-admin'): $sortLabel = __('<span class="icon"></span>Ascending', array(), 'a-admin'); ?>

    <?php echo link_to(
			$sortLabel,
			'aEventAdmin/index?sort=author_id&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'), 
			array('class' => 'a-btn flag flag-right a-sort-arrow no-bg no-label icon alt sorting '.$sort[1].(($sort[1] == 'asc') ? ' a-arrow-up' : ' a-arrow-down'), 'title' => __($sortLabel, array(), 'a-admin'))) 
		?>
		
    <?php else: ?>

    <?php echo link_to(
      __('<span class="icon"></span>Ascending', array(), 'a-admin'),
      'aEventAdmin/index?sort=author_id&sort_type=asc', 
			array('class' => 'a-btn flag flag-right a-sort-arrow not-sorting no-bg no-label icon a-arrow-up alt asc', 'title' => __('Ascending', array(), 'a-admin')))
		?>
		
  <?php endif; ?>

  	</th>
	<?php end_slot(); ?>

<?php include_slot('a-admin.current-header') ?>
	<?php slot('a-admin.current-header') ?>
	<th class="a-admin-manykey a-column-editors_list">
      <span class="a-simple-title"><?php echo __('Editors', array(), 'messages') ?></span>
  
  	</th>
	<?php end_slot(); ?>

<?php include_slot('a-admin.current-header') ?>
	<?php slot('a-admin.current-header') ?>
	<th class="a-admin-text a-column-tags_list">
          <ul class="a-multi-title">
      <li><a href="#" class="a-btn a-sort-label alt"><?php echo __('Tags', array(), 'messages') ?></a>
        <div class="filternav tags_list">
          <hr/>
          <?php include_partial('aEventAdmin/list_th_tags_list_dropdown', array('filters' => $filters, 'name' => 'tags_list'  )) ?>
            </div>
      </li>
    </ul>
  
  	</th>
	<?php end_slot(); ?>

<?php include_slot('a-admin.current-header') ?>
	<?php slot('a-admin.current-header') ?>
	<th class="a-admin-manykey a-column-categories_list">
          <ul class="a-multi-title">
      <li><a href="#" class="a-btn a-sort-label alt"><?php echo __('Categories', array(), 'messages') ?></a>
        <div class="filternav categories_list">
          <hr/>
          <?php include_partial('aEventAdmin/list_th_dropdown', array('filters' => $filters, 'name' => 'categories_list'  )) ?>    
            </div>
      </li>
    </ul>
  
  	</th>
	<?php end_slot(); ?>

<?php include_slot('a-admin.current-header') ?>
	<?php slot('a-admin.current-header') ?>
	<th class="a-admin-enum a-column-status">
          <ul class="a-multi-title">
      <li><a href="#" class="a-btn a-sort-label alt"><?php echo __('Status', array(), 'messages') ?></a>
        <div class="filternav status">
          <hr/>
          <?php include_partial('aEventAdmin/list_th_dropdown', array('filters' => $filters, 'name' => 'status'  )) ?>    
            </div>
      </li>
    </ul>
  
    
  <?php if ('status' == $sort[0]): ?>

		<?php ($sort[1] == 'asc')? $sortLabel = __('<span class="icon"></span>Descending', array(), 'a-admin'): $sortLabel = __('<span class="icon"></span>Ascending', array(), 'a-admin'); ?>

    <?php echo link_to(
			$sortLabel,
			'aEventAdmin/index?sort=status&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'), 
			array('class' => 'a-btn flag flag-right a-sort-arrow no-bg no-label icon alt sorting '.$sort[1].(($sort[1] == 'asc') ? ' a-arrow-up' : ' a-arrow-down'), 'title' => __($sortLabel, array(), 'a-admin'))) 
		?>
		
    <?php else: ?>

    <?php echo link_to(
      __('<span class="icon"></span>Ascending', array(), 'a-admin'),
      'aEventAdmin/index?sort=status&sort_type=asc', 
			array('class' => 'a-btn flag flag-right a-sort-arrow not-sorting no-bg no-label icon a-arrow-up alt asc', 'title' => __('Ascending', array(), 'a-admin')))
		?>
		
  <?php endif; ?>

  	</th>
	<?php end_slot(); ?>

<?php include_slot('a-admin.current-header') ?>
	<?php slot('a-admin.current-header') ?>
	<th class="a-admin-date a-column-start_date">
      <span class="a-simple-title"><?php echo __('Date', array(), 'messages') ?></span>
  
    
  <?php if ('start_date' == $sort[0]): ?>

		<?php ($sort[1] == 'asc')? $sortLabel = __('<span class="icon"></span>Descending', array(), 'a-admin'): $sortLabel = __('<span class="icon"></span>Ascending', array(), 'a-admin'); ?>

    <?php echo link_to(
			$sortLabel,
			'aEventAdmin/index?sort=start_date&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'), 
			array('class' => 'a-btn flag flag-right a-sort-arrow no-bg no-label icon alt sorting '.$sort[1].(($sort[1] == 'asc') ? ' a-arrow-up' : ' a-arrow-down'), 'title' => __($sortLabel, array(), 'a-admin'))) 
		?>
		
    <?php else: ?>

    <?php echo link_to(
      __('<span class="icon"></span>Ascending', array(), 'a-admin'),
      'aEventAdmin/index?sort=start_date&sort_type=asc', 
			array('class' => 'a-btn flag flag-right a-sort-arrow not-sorting no-bg no-label icon a-arrow-up alt asc', 'title' => __('Ascending', array(), 'a-admin')))
		?>
		
  <?php endif; ?>

  	</th>
	<?php end_slot(); ?>

<?php include_slot('a-admin.current-header') ?>
