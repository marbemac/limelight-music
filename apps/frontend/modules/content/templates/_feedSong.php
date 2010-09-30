<li class="feed song">
  <div class="play_score_box">
    <div class="song_play_pause"></div>
  </div>



  <div class="title">
    <?php
    include_partial('content/scoreBox', array(
        'class' => 'news_'.$item['id'],
        'score' => $item['score'],
        'type' => 'sb_l',
        'target' => '.news_'.$item['id'],
        'title' => 'rate this news story',
        'my' => 'bottom left',
        'at' => 'top center',
        'url' => url_for('news_rate_box', array('id' => $item['id']))
      )
    );
    ?>
    <?php echo link_to($item['title'], 'news_show', array('title_slug' => $item['title_slug']), 'class=title') ?>
    <div class="date">submitted <?php echo LimelightUtils::timeLapse($item['created_at']) ?></div>
  </div>

  <div class="content">
    <span class="source">
      <span>via</span>
      <?php echo link_to($item['Links'][0]['Source']['name'], $item['Links'][0]['source_url']) ?>

      <?php if (count($item['Links']) > 1): ?>
      <div class="more_button">+<?php echo count($item['Links'])-1 ?></div>
      <div class="more_box hide">
        <?php foreach ($item['Links'] as $key => $link): ?>
        <?php if ($key != 0): ?>

        <?php echo $key.'. '.link_to($link['Source']['name'], $link['source_url']) ?>

        <?php endif ?>
        <?php endforeach ?>
      </div>
      <?php endif ?>

    </span> -
    <?php
    if ($item['news_image'] != 'news_profile_default.gif')
      echo image_tag(sfConfig::get('app_news_image_path') . '/small/' . $item['news_image'], array('class' => 'story_img rnd_3', 'alt' => $item['title'].' image'));
    ?>
    <p>
      <?php echo substr($item['content'], 0, 220) ?>
      <?php echo (strlen($item['content']) > 230) ? '...' : '' ?>
    </p>
    <div class="clear"></div>
  </div>

  <div class="stat_box rndB_3">
    <div class="submit_by">
      submitted by
      <?php
      include_component('user', 'userLink', array(
      'user_id'        => $item['user_id'],
      'show_score'     => true,
      'pos'            => 'top',
      ));
      ?>
    </div>
    <div class="stat rnd_3">
      <span class="item">views</span>
      <span class="value"><?php echo $item['total_views'] ?></span>
    </div>
    <div class="stat rnd_3">
      <span class="item">comments</span>
      <span class="value"><?php echo count($item['Comments']) ?></span>
    </div>
    <div class="stat rnd_3">
      <span class="item">favorited</span>
      <span class="value"><?php echo count($item['Favorited']) ?></span>
    </div>
    <div class="clear"></div>
    <ul>
      <?php foreach ($item['Limelights'] as $key => $limelight): ?>
      <li>
        <?php
        $ll_title = $limelight['company_name'] ? $limelight['company_name'].' '.$limelight['name'] : $limelight['name'];
        echo link_to(image_tag(sfConfig::get('app_limelight_image_path').'/thumb/'.$limelight['profile_image'], array('alt' => $ll_title.' icon', 'title' => $ll_title)), 'lime_show', array('name_slug' => $limelight['name_slug']))
        ?>
      </li>
      <?php endforeach ?>
    </ul>
    <div class="clear"></div>
  </div>
</li>