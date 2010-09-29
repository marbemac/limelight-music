<?php include_partial('content/layoutPart1'); ?>

<?php
slot('title', sprintf('%s products | Tech Limelight', $limelight['name']));
include_component('limelight', 'limelightHead', array('limelight' => $limelight, 'page' => 'products', 'sf_cache_key' => $limelight['id'].'-products'));
?>

<div class="content_panel">
  <ul class="limelight_products_feed">
  <?php
    include_partial('user/actionFeed', array('items' => $items, 'limelight_id' => $limelight_id, 'next_page' => $next_page, 'type' => 'limelight', 'feed_more_url' => $feed_more_url));
  ?>
  </ul>
</div>

<?php include_partial('content/layoutPart2'); ?>