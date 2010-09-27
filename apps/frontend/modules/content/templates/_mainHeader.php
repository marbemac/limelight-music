<div id="h_wrapper">
  <a id="h_logo" href="<?php echo url_for('@homepage') ?>"><img src="/images/header_logo.png" alt="tech limelight logo image" /></a>
  <?php echo image_tag('beta_sign.png', array('id' => 'h_beta_sign')) ?>

  <?php echo link_to('add song', '@song_add', array('class' => 'h_link_1 rnd_3', 'id' => 'h_news')) ?>
  <?php echo link_to('add limelight', '@lime_suggest', array('class' => 'h_link_1 rnd_3', 'id' => 'h_limelight')) ?>
  <?php echo link_to('help', '@homepage', array('class' => 'h_link_2 rnd_3', 'id' => 'h_help')) ?>

  <div id="h_search" class="rnd_3">
    <input type="text" class="rnd_3"></input>
    <div class="T">search</div>
  </div>

  <?php if ($sf_user->isAuthenticated()): ?>
    <div id="h_user_panel">
      <?php echo link_to($sf_user->getGuardUser()->username, '@user_show?username='.$sf_user->getGuardUser()->username, 'class=username') ?>
      <div id="h_notification_num" class="rnd_5" title="you have <?php echo LimelightUtils::getNotificationCount($sf_user->getGuardUser()->id) ?> notification(s)">
        <?php echo link_to(LimelightUtils::getNotificationCount($sf_user->getGuardUser()->id), '@user_show?username='.$sf_user->getGuardUser()->username) ?>
      </div>
      <div id="h_score" class="rnd_3" title="this is your limelight score"><?php echo $sf_user->getGuardUser()->Profile->score ?></div>
      <div class="clear"></div>
      <?php echo link_to('my account', '@user_show?username='.$sf_user->getGuardUser()->username, 'class=my_account rnd_3') ?>
      <?php echo link_to('logout', '@sf_guard_signout', 'class=logout rnd_3 id=logout_button') ?>
      <a class="rpxnow" id="h_relogin" href="https://tech-limelight.rpxnow.com/openid/v2/signin?token_url=<?php echo urlencode(sfConfig::get('app_rpx_tokenize_url')) ?>">Relogin</a>
    </div>
  <?php else: ?>
    <a class="rpxnow" id="h_login" class="login" onclick="return false;" href="https://tech-limelight.rpxnow.com/openid/v2/signin?token_url=<?php echo urlencode(sfConfig::get('app_rpx_tokenize_url')) ?>">Sign In</a>
    <a class="rpxnow" id="h_register" class="register" onclick="return false;" href="https://tech-limelight.rpxnow.com/openid/v2/signin?token_url=<?php echo urlencode(sfConfig::get('app_rpx_tokenize_url')) ?>">Register</a>
  <?php endif ?>
</div>