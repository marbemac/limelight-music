<?php
  slot('title', $user->username.' favorites');
  slot('sidebar0');
    include_component('user', 'profileCard', array('user' => $user));
  end_slot();
?>

<?php include_component('user', 'notifications', array('user' => $user)) ?>
<?php include_partial('user/profileNav', array('user' => $user, 'page' => 'favorited')) ?>
<div class="content_panel rnd_3">
  <ul class="filters">
    <li class="head">show</li>
    <li class="show news on" data-target="#news_sb">news</li>
    <li class="show limelight" data-target="#limelight_sb">limelights</li>
  </ul>
  <ul class="filter_sort_by news on" id="news_sb" data-target=".user_action_feed">
    <li class="head">sorted by</li>
    <li class="on" data-url="<?php echo url_for('user_favorited_more', array('username' => $sf_params->get('username'), 'page' => 1, 'type' => 'news', 'order_by' => 'favorite_date')) ?>">date favorited</li>
    <li data-url="<?php echo url_for('user_favorited_more', array('username' => $user->username, 'page' => 1, 'type' => 'news', 'order_by' => 'submit_date')) ?>">date submitted</li>
    <li data-url="<?php echo url_for('user_favorited_more', array('username' => $sf_params->get('username'), 'page' => 1, 'type' => 'news', 'order_by' => 'score')) ?>">score</li>
    <li data-url="<?php echo url_for('user_favorited_more', array('username' => $sf_params->get('username'), 'page' => 1, 'type' => 'news', 'order_by' => 'views')) ?>">views</li>
  </ul>
  <ul class="filter_sort_by limelight off" id="limelight_sb" data-target=".user_action_feed">
    <li class="head">sorted by</li>
    <li data-url="<?php echo url_for('user_favorited_more', array('username' => $sf_params->get('username'), 'page' => 1, 'type' => 'limelight', 'order_by' => 'favorite_date')) ?>">date favorited</li>
    <li data-url="<?php echo url_for('user_favorited_more', array('username' => $sf_params->get('username'), 'page' => 1, 'type' => 'limelight', 'order_by' => 'submit_date')) ?>">date submitted</li>
    <li data-url="<?php echo url_for('user_favorited_more', array('username' => $sf_params->get('username'), 'page' => 1, 'type' => 'limelight', 'order_by' => 'score')) ?>">score</li>
    <li data-url="<?php echo url_for('user_favorited_more', array('username' => $sf_params->get('username'), 'page' => 1, 'type' => 'limelight', 'order_by' => 'views')) ?>">views</li>
  </ul>

  <ul class="user_action_feed">
    <?php include_partial('user/actionFeed', array('items' => $items, 'user' => $user, 'next_page' => $next_page, 'feed_more_url' => $feed_more_url, 'type' => $type)) ?>
  </ul>
</div>