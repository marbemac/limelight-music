<div class="user_tab">
  <div class="head"><?php echo $user->username ?></div>
  <div class="score"><?php echo $user->Profile->score ?></div>
  <img class="prof_img" src="<?php echo sfConfig::get('app_user_profile_image_path').'/thumb/'.$user->Profile->profile_image ?>" />
  <div class="h_badges infobox rnd_3">
    <?php $badge_levels = LimelightUtils::getUserBadgeLevels($user->id) ?>
    <?php for ($i=0; $i<sfConfig::get('app_badge_num_levels'); $i++): ?>
      <?php $badge_num = isset($badge_levels[$i]) ? $badge_levels[$i]['badge_count'] : '0' ?>
      <span class="<?php echo LimelightUtils::getBadgeClass($i) ?>">
        <img src="/images/lvl<?php echo $i+1 ?>_badge.gif" /><?php echo $badge_num ?>
      </span>
    <?php endfor ?>
  </div>
  <?php echo $sf_data->getRaw('groupText') ?>
</div>