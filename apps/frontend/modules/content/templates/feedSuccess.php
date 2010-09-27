<?php

//use_javascript('filter.js');
//use_stylesheet('filter.css');
//use_stylesheet('feed.css');

slot('title', 'uncovering trending songs and artists');

slot('sidebar0');
end_slot();

$filters = $sf_user->getAttribute('filters');
?>

<div class="content_panel">
  <?php include_partial('feedFilters') ?>
  <ul id="main_feed">
    <?php
    include_partial('user/actionFeed', array('items' => $items, 'next_page' => $next_page, 'feed_more_url' => $feed_more_url, 'type' => $filters['feed_type']))
    ?>
  </ul>
</div>