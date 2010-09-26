<?php if ($sf_user->isAuthenticated() && $sf_user->getGuardUser()->id == $user->id): ?>
  <div class="user_notifications rnd_5">
    <h5>notifications</h5>
    <?php if (count($notifications) == 0): ?>
      <h6>you have no new notifications</h6>
    <?php else: ?>
      <?php echo link_to('clear all', '@user_clear_notifications', 'class=notification_clear_all rnd_3 title=clear all your notifications') ?>
      <?php foreach ($notifications as $key => $notification): ?>
        <?php if (count($notifications) > sfConfig::get('app_user_notifications_max') && $key == sfConfig::get('app_user_notifications_max')): ?>
          <div id="notification_more_list" class="hide" data-count="<?php echo count($notifications) - sfConfig::get('app_user_notifications_max') ?>">
        <?php endif ?>
        <div id="notification_<?php echo $notification['id'] ?>" class="notification">
          <span class="<?php echo $notification['type'] ?> type rnd_3"><?php echo $notification['type'] ?></span>
          <span class="time_lapse"><?php echo LimelightUtils::timeLapse($notification['created_at']) ?></span>
          <?php echo $notification['message'] ?>
          <?php echo link_to('X', '@user_delete_notification?id='.$notification['id'], 'class=notification_delete rnd_3 title=delete this notification') ?>
        </div>
      <?php endforeach ?>
      <?php if (count($notifications) > sfConfig::get('app_user_notifications_max')): ?>
        </div>
        <div class="blind list_more rnd_3" blindElem="notification_more_list" blindText="hide extra notifications">show <?php echo count($notifications) - sfConfig::get('app_user_notifications_max') ?> more</div>
        <div class="clear"></div>
      <?php endif ?>
    <?php endif ?>
  </div>
<?php endif ?>