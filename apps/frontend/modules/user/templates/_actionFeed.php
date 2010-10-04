<?php
foreach ($items as $key => $item) {
  if (isset($item['type'])) // we're using the user actions table
  {
    if ($item['type'] == 'Limelight')
      include_component('content', 'feedLimelight', array('id' => $item['Limelight_id'], 'sf_cache_key' => $item['Limelight_id']));
    elseif ($item['type'] == 'News')
      include_component('content', 'feedNews', array('id' => $item['News_id'], 'sf_cache_key' => $item['News_id']));
    elseif ($item['type'] == 'Song')
      include_component('content', 'feedSong', array('id' => $item['Song_id'], 'sf_cache_key' => $item['Song_id']));
    elseif ($item['type'] == 'Comment')
      include_component('content', 'feedComment', array('id' => $item['Comment_id'], 'sf_cache_key' => $item['Comment_id']));
  }
  else
  {
    $id = isset($item['item_id']) ? $item['item_id'] : $item['id'];
    if (isset($type) && strtolower($type) == 'limelight')
      include_component('content', 'feedLimelight', array('id' => $id, 'sf_cache_key' => $id));
    else if (isset($type) && strtolower($type) == 'news')
      include_component('content', 'feedNews', array('id' => $id, 'sf_cache_key' => $id));
    else if (isset($type) && strtolower($type) == 'song')
      include_component('content', 'feedSong', array('id' => $id, 'sf_cache_key' => $id));
    else if (isset($type) && strtolower($type) == 'comment')
      include_component('content', 'feedComment', array('id' => $id, 'sf_cache_key' => $id));
  }
}
?>

<li class="last">

<?php
if (isset($user))
{
  $type = 'user';
  $target = '.user_action_feed';
}
else if (isset($limelight_id))
{
  $type = 'limelight';
  $target = '.limelight_news_feed';
}
else
{
  $type = 'main';
  $target = '#main_feed';
}
?>

<?php if ($type == 'user' && count($items) == 0 && $next_page == 2): ?>
  <h3>
    <?php if ($sf_user->isAuthenticated() && $sf_user->getGuardUser()->username == $user->username): ?>
      <?php if (sfContext::getInstance()->getActionName() == 'minifeed'): ?>
        you have no feed items to display, try contributing something!
      <?php elseif (sfContext::getInstance()->getActionName() == 'followingUser'): ?>
        you're not currently following any users, give it a try!
      <?php elseif (sfContext::getInstance()->getActionName() == 'followingLimelight'): ?>
        you're not currently following any limelights, give it a try!
      <?php else: ?>
        you have not favorited any items yet
      <?php endif ?>
    <?php else: ?>
      <?php if (sfContext::getInstance()->getActionName() == 'minifeed'): ?>
        <?php echo $user->username ?> has not contributed anything yet!
      <?php elseif (sfContext::getInstance()->getActionName() == 'followingUser'): ?>
        <?php echo $user->username ?> is not currently following any users
      <?php elseif (sfContext::getInstance()->getActionName() == 'followingLimelight'): ?>
        <?php echo $user->username ?> is not currently following any limelights
      <?php else: ?>
        <?php echo $user->username ?> has not favorited any items
      <?php endif ?>
    <?php endif ?>
  </h3>
<?php elseif (count($items) < sfConfig::get('app_'.$type.'_feed_num')): ?>
  <h3>that's it, there are no more feed items to show!</h3>
<?php else: ?>
  <?php
  $params = array('page' => $next_page, 'type' => $sf_params->get('type', ''), 'order_by' => $sf_params->get('order_by', ''), 'category' => $sf_params->get('category', ''));
  if (isset($user))
    $params['username'] = $user->username;
  if ($type == 'limelight')
  {
    $params['id'] = $limelight_id;
    $params['type'] = $limelight_type;
  }
  ?>
  <a href="<?php echo url_for($feed_more_url, $params) ?>" class="feed_more rnd_3" data-target="<?php echo $target ?>">show more</a>
<?php endif ?>
</li>