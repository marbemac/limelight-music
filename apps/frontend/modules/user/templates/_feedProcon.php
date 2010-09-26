<li class="user_feed_item <?php echo $item['type'] ?>">
  <img class="icon" src="/images/<?php echo $item['type'] ?>_icon.png" title="<?php echo $user->username ?> added a <?php echo $item['type'] ?> to a limelight" />
  <h3>
    <?php echo $user->username ?> added a <?php echo $item['type'] ?> to the
    <?php
    include_component('limelight', 'limelightLink', array(
      'id'           => $item['limelight_id'],
      'pic'          => true,
      'score'        => true,
      'sf_cache_key' => $item['limelight_id']
    ));
    ?>
    limelight
  </h3>
  <div class="created">
    added on <?php echo date('M j @ g:i A', strtotime($item['created_at'])) ?>
  </div>
  <div class="content">" <?php echo $item['name'] ?> "</div>
  <div class="clear"></div>
</li>