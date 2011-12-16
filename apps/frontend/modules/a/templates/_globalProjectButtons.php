<?php // This partial is loaded at the end of the list of admin bar buttons. ?>
<?php if ($sf_user->hasCredential('admin') || $sf_user->hasCredential('peopleAdmin')): ?>
  <li><?php echo link_to('<span class="icon"></span>People', 'aPeople_admin', array(), array('class' => 'a-btn icon a-users no-bg alt')) ?></li>
<?php endif ?>