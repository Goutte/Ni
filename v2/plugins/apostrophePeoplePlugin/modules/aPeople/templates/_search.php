<ul class="people-search-results">
	<h3>Faculty &amp; People</h3>
	<br />
  <?php foreach ($results as $person): ?>
    <li><?php echo link_to($person, 'aPeople/show?' . http_build_query(array('slug' => $person->slug, 'engine-slug' => $person->getEngineSlug()))) ?></li>
  <?php endforeach ?>
</ul>
