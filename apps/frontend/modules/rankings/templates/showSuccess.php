<?php
use_stylesheet('rankings.css');
use_javascript('rankings.js');

slot('title', 'Rankings | Tech Limelight');
?>

<h1 class="rnd_3 tipBox" tipText="The rankings below represent the top 10 users, limelights, and news stories across the whole of <?php echo sfConfig::get('app_site_name') ?>. All of the rankings are updated live, enjoy!">Rankings</h1>

<div class="hide" id="timer_1" link="<?php echo url_for('@rankings_ajax?period=1') ?>" period="1"></div>
<div class="hide" id="timer_7" link="<?php echo url_for('@rankings_ajax?period=7') ?>" period="7"></div>
<div class="hide" id="timer_30" link="<?php echo url_for('@rankings_ajax?period=30') ?>" period="30"></div>

<div class="users">
  <div class="box_title rnd_3">users</div>
  <ul class="rank_box rnd_3" id="users_1">
  <div class="list_title">24 hours</div>
  <?php foreach($users1 as $key => $user): ?>
    <?php include_partial('userItem', array('user' => $user, 'key' => $key)) ?>
  <?php endforeach; ?>
  </ul>
  <ul class="rank_box rnd_3" id="users_7">
  <div class="list_title">1 week</div>
  <?php foreach($users7 as $key => $user): ?>
    <?php include_partial('userItem', array('user' => $user, 'key' => $key)) ?>
  <?php endforeach; ?>
  </ul>
  <ul class="rank_box rnd_3" id="users_30">
  <div class="list_title">1 month</div>
  <?php foreach($users30 as $key => $user): ?>
    <?php include_partial('userItem', array('user' => $user, 'key' => $key)) ?>
  <?php endforeach; ?>
  </ul>
</div>

<div class="limelights">
  <div class="box_title rnd_3">limelights</div>
  <ul class="rank_box rnd_3" id="limelights_1">
  <div class="list_title">24 hours</div>
  <?php foreach($limelights1 as $key => $ll): ?>
    <?php include_partial('limelightItem', array('ll' => $ll, 'key' => $key)) ?>
  <?php endforeach; ?>
  </ul>
  <ul class="rank_box rnd_3" id="limelights_7">
  <div class="list_title">1 week</div>
  <?php foreach($limelights7 as $key => $ll): ?>
    <?php include_partial('limelightItem', array('ll' => $ll, 'key' => $key)) ?>
  <?php endforeach; ?>
  </ul>
  <ul class="rank_box rnd_3" id="limelights_30">
  <div class="list_title">1 month</div>
  <?php foreach($limelights30 as $key => $ll): ?>
    <?php include_partial('limelightItem', array('ll' => $ll, 'key' => $key)) ?>
  <?php endforeach; ?>
  </ul>
</div>

<div class="news">
  <div class="box_title rnd_3">news</div>
  <ul class="rank_box rnd_3" id="news_1">
  <div class="list_title">24 hours</div>
  <?php foreach($newss1 as $key => $news): ?>
    <?php include_partial('newsItem', array('news' => $news, 'key' => $key)) ?>
  <?php endforeach; ?>
  </ul>
  <ul class="rank_box rnd_3" id="news_7">
  <div class="list_title">1 week</div>
  <?php foreach($newss7 as $key => $news): ?>
    <?php include_partial('newsItem', array('news' => $news, 'key' => $key)) ?>
  <?php endforeach; ?>
  </ul>
  <ul class="rank_box rnd_3" id="news_30">
  <div class="list_title">1 month</div>
  <?php foreach($newss30 as $key => $news): ?>
    <?php include_partial('newsItem', array('news' => $news, 'key' => $key)) ?>
  <?php endforeach; ?>
  </ul>
</div>