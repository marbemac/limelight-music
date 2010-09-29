<?php include_partial('content/layoutPart1'); ?>

<?php
  slot('title', $user->username.' following users');
  slot('sidebar0');
    include_component('user', 'profileCard', array('user' => $user));
    include_partial('user/followingUsers', array('user' => $user, 'following' => $following['Following']));
  end_slot();
?>

<?php include_component('user', 'notifications', array('user' => $user)) ?>
<?php include_partial('user/profileNav', array('user' => $user, 'page' => 'user_following')) ?>
<div class="content_panel">
  <ul class="user_action_feed">
    <?php include_partial('user/actionFeed', array('items' => $items, 'user' => $user, 'next_page' => $next_page, 'feed_more_url' => $feed_more_url)) ?>
  </ul>
</div>

<?php include_partial('content/layoutPart2'); ?>