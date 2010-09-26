<h2 class="profile_card_H">
  <?php echo $user->username ?>
  <span class="score rnd_3"><?php echo $user->Profile->score ?></span>
</h2>
<div class="sidebar_C profile_card rnd_3">

  <div class="profile_image">
    <?php if ($sf_user->isAuthenticated() && $sf_user->getGuardUser()->id == $user->id): ?>
      <div id="user_cpi" data-url="<?php echo url_for('user_image_update', array('id' => $user->id)) ?>"></div>
    <?php endif ?>
    <img src="<?php echo sfConfig::get('app_user_profile_image_path').'/med/'.$user->Profile->profile_image ?>" class="rnd_3" alt="<?php echo $user->username ?>'s user icon"/>
    <div class="member_time">last login on <?php echo date('M d, y', strtotime($user->updated_at)) ?></div>
    <div class="member_time">member since <?php echo date('M d, y', strtotime($user->created_at)) ?></div>
  </div>

  <ul class="following_stats">
    <li>
      <?php
        if (!$sf_user->isAuthenticated() || $sf_user->getGuardUser()->id != $user->id) {
          include_partial('content/followButton', array(
            'class' => 'user_follow_'.$user->id,
            'target' => '.user_follow_'.$user->id,
            'title' => 'follow or unfollow this user',
            'my' => 'top center',
            'at' => 'bottom center',
            'url' => url_for('user_follow_box', array('id' => $user->id))
          ));
        }
      ?>

      <?php if ($sf_user->isAuthenticated() && $sf_user->getGuardUser()->id == $user->id && !$sf_user->getGuardUser()->username_changed): ?>
        <div class="username_change rnd_3" data-url="<?php echo url_for('user_username_change') ?>">change username</div>
      <?php endif ?>
    </li>
    <li class="box rnd_3"><span>followers</span><?php echo count($following['Followers']) ?></li>
    <li class="box rnd_3"><span>following</span><?php echo count($following['Following']) ?></li>
  </ul>
  
  <div class="clear"></div>

  <ul class="badge_counts">
    <?php for ($i=0; $i<sfConfig::get('app_badge_num_levels'); $i++): ?>
      <?php
      $badge_num = 0;
      foreach ($badgeLevels as $level) {
        if ($level['level_completed'] == $i+1)
          $badge_num = $level['badge_count'];
      }
      ?>
      <li>
        <div><?php echo LimelightUtils::getBadgeName($i) ?></div>
        <img src="/images/lvl<?php echo $i+1 ?>_badge_l.jpg" alt="lvl<?php echo $i+1 ?> badges" />
        <span class="lvl_<?php echo $i+1 ?> rnd_3"><?php echo $badge_num ?></span>
      </li>
    <?php endfor ?>
  </ul>

  <div class="clear"></div>

</div>