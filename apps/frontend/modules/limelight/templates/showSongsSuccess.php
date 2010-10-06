<?php include_partial('content/layoutPart1'); ?>

<?php
slot('title', sprintf('%s Songs | Tech Limelight', $limelight['name']));
include_component('limelight', sfConfig::get('app_site_type').'LimelightHead', array('limelight' => $limelight, 'page' => 'song', 'sf_cache_key' => $limelight['id'].'-song'));
?>

<div class="content_panel">
  <ul class="limelight_song_feed">
  <?php
    include_partial('user/actionFeed', array('items' => $items, 'limelight_id' => $limelight_id, 'next_page' => $next_page, 'type' => 'song', 'feed_more_url' => $feed_more_url));
  ?>
  </ul>
</div>

<?php include_partial('content/layoutPart2'); ?>