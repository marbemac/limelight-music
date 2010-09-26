<?php

//use_javascript('filter.js');
//use_stylesheet('filter.css');
//use_stylesheet('feed.css');

slot('title', 'the latest technology news');

slot('sidebar0');
end_slot();
?>

<?php
$filters = $sf_user->getAttribute('filters');

if ($sf_params->get('action') == 'feed' && ((!$sf_user->isAuthenticated() && $sf_user->getAttribute('show_welcome_splash', true)) || ($sf_user->isAuthenticated() && $sf_user->getGuardUser()->show_welcome_splash)))
  $feedClass = ' home_welcome_placeholder';
else
  $feedClass = '';
?>

<div class="content_panel<?php echo $feedClass ?>">
  <?php include_partial('feedFilters') ?>
  <ul id="main_feed">
    <?php
    include_partial('user/actionFeed', array('items' => $items, 'next_page' => $next_page, 'feed_more_url' => $feed_more_url, 'type' => $filters['feed_type']))
    ?>
  </ul>
</div>