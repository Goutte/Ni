<td colspan="7">
  <?php echo __('%%title%% - %%author_id%% - %%editors_list%% - %%tags_list%% - %%categories_list%% - %%status%% - %%start_date%%', array('%%title%%' => get_partial('aEventAdmin/title', array('type' => 'list', 'a_event' => $a_event)), '%%author_id%%' => get_partial('aEventAdmin/author_id', array('type' => 'list', 'a_event' => $a_event)), '%%editors_list%%' => get_partial('aEventAdmin/editors_list', array('type' => 'list', 'a_event' => $a_event)), '%%tags_list%%' => get_partial('aEventAdmin/tags_list', array('type' => 'list', 'a_event' => $a_event)), '%%categories_list%%' => get_partial('aEventAdmin/categories_list', array('type' => 'list', 'a_event' => $a_event)), '%%status%%' => $a_event->getStatus(), '%%start_date%%' => get_partial('aEventAdmin/start_date', array('type' => 'list', 'a_event' => $a_event))), 'messages') ?>
</td>