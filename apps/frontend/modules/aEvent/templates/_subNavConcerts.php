<?php use_helper('Date') ?>

<?php foreach ($concerts as $concert): ?>

<h5>
  <?php echo link_to(format_date($concert->start_date, 'D'), 'a_event_post', $concert) ?>
</h5>
| <?php echo $concert->getFeedTitle() ?>

<br />

<?php endforeach ?>