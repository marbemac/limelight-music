<?php
if ((!$sf_user->isAuthenticated() && $sf_user->getAttribute('show_help', true)) || ($sf_user->isAuthenticated() && $sf_user->getGuardUser()->show_help))
  $feedClass = 'help_adjust';
else
  $feedClass = '';
?>

<div class="home_welcome <?php echo $feedClass ?> rnd_5">
    <div class="main">
      <div class="welcome">Welcome to <?php echo sfConfig::get('app_site_name') ?></div>
      <?php echo image_tag('home_welcome_arrow.gif') ?>
      <div class="more_features rnd_3">see more features</div>
      <div class="hide_features rnd_3" data-url="<?php echo url_for('hide_welcome_splash') ?>">hide this stuff</div>
      <p>
        Use <?php echo sfConfig::get('app_site_name') ?> to discover new music. <?php echo sfConfig::get('app_site_name') ?> lets users follow other users and artists,
        rate songs and artists, discover the latest trending songs and artists, and more.
      </p>
    </div>
    <?php include_partial('content/homeWelcomeInfoboxes') ?>
  </div>