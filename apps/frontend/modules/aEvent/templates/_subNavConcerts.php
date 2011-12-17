<?php foreach ($concerts as $concert): ?>

<h5>
  <?php echo link_to($concert->getStartDate(), 'a_event_post', $concert) ?>
</h5>
| <?php echo $concert->getFeedTitle() ?>

<?php endforeach ?>