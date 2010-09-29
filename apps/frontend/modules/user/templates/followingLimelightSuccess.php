<?php include_partial('content/layoutPart1'); ?>

<?php
  slot('title', $user->username.' following limelights');
  slot('sidebar0');
    include_component('user', 'profileCard', array('user' => $user));
    include_partial('user/followingLimelights', array('user' => $user, 'following' => $following_limelights['Following']));
  end_slot();
?>

<?php include_component('user', 'notifications', array('user' => $user)) ?>
<?php include_partial('user/profileNav', array('user' => $user, 'page' => 'lime_following')) ?>
<div class="content_panel">
  <ul class="user_action_feed">
    <?php include_partial('user/actionFeed', array('items' => $items, 'user' => $user, 'next_page' => $next_page, 'feed_more_url' => $feed_more_url)) ?>
  </ul>
</div>

<?php include_partial('content/layoutPart2'); ?>