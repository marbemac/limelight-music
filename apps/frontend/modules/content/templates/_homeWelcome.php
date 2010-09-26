<?php
if ((!$sf_user->isAuthenticated() && $sf_user->getAttribute('show_help', true)) || ($sf_user->isAuthenticated() && $sf_user->getGuardUser()->show_help))
  $feedClass = 'help_adjust';
else
  $feedClass = '';
?>

<div class="home_welcome <?php echo $feedClass ?> rnd_5">
    <div class="main">
      <div class="welcome">Welcome to Tech Limelight</div>
      <?php echo image_tag('home_welcome_arrow.gif') ?>
      <div class="more_features rnd_3">see more features</div>
      <div class="hide_features rnd_3" data-url="<?php echo url_for('hide_welcome_splash') ?>">hide this stuff</div>
      <p>
        Use Tech Limelight to follow the latest news on your favorite products and companies, find new
        products, and more. Tech Limelight organizes community contributed information around single
        pages called Limelights. Each Limelight represents a single product, technology, or company.
      </p>
    </div>
    <?php include_partial('content/homeWelcomeInfoboxes') ?>
  </div>