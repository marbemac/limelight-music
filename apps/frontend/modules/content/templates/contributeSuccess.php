<?php
slot('title', 'contribute');
?>

<div class="content_panel contribute">
  <p class="rnd_3">
    There are many ways to contribute to <?php echo sfConfig::get('app_site_name') ?>.
    Some actions require a minimum user score.
    Almost everything you contribute can be voted up or down by the community, which in turn affects your user account score.
  </p>
  <ul>
    <li class="news">
      <?php echo link_to('submit a news story', '@news_add', array('class' => 'title rnd_3')) ?>
      <?php echo link_to(image_tag('news_icon_L.gif'), '@news_add') ?>
      <div class="rndT_3">minimum score <?php echo LimelightUtils::getUserActionMinScore('submit news story') ?></div>
    </li>
    <li class="limelight">
      <?php echo link_to('suggest a limelight', '@lime_suggest', array('class' => 'title rnd_3')) ?>
      <?php echo link_to(image_tag('ll_icon_L.png'), '@lime_suggest') ?>
      <div class="rndT_3">minimum score <?php echo LimelightUtils::getUserActionMinScore('suggest a limelight') ?></div>
    </li>
  </ul>
</div>