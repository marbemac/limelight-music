<li class="feed song" id="song_<?php echo $item['id'] ?>">
  <div class="play_score_box">
    <div class="song_play_pause play" data-id="<?php echo $item['id'] ?>" data-url="<?php echo url_for('song_play_pause', array('id' => $item['id'])) ?>"></div>

    <?php
    include_component('content', 'scoreBoxFull', array(
        'item_id' => $item['id'],
        'type' => 'Song',
        'orientation' => 'vertical',
        'sf_cache_key' => 'song-'.$item['id'].'-'.($sf_user->isAuthenticated() ? $sf_user->getGuardUser()->id : 0)
      )
    );
    ?>
  </div>

  <?php echo link_to($item['name'], 'song_show', array('name_slug' => $item['name_slug']), 'class=name') ?>
  <div class="clear"></div>
  <div class="date">
    submitted <?php echo LimelightUtils::timeLapse($item['created_at']) ?> by
    <?php
    include_component('user', 'userLink', array(
    'user_id'        => $item['user_id'],
    'show_score'     => true,
    'pos'            => 'top',
    ));
    ?>
  </div>
  <div class="content"><?php echo $item['content'] ?></div>

  <div class="ll_box rnd_3">
    <div class="interact_box">
      <div class="plays rnd_3" title="<?php echo $item['total_plays'] ?> plays"><?php echo $item['total_plays'] ?></div>
      <?php
      include_component('content', 'favorite', array(
          'item_id' => $item['id'],
          'type' => 'Song',
          'sf_cache_key' => 'song-'.$item['id'].'-'.($sf_user->isAuthenticated() ? $sf_user->getGuardUser()->id : 0)
        )
      );
      ?>
      <div class="share">share</div>
      <div class="buy">buy it</div>
    </div>

    <?php
    foreach ($item['Limelights'] as $limelight)
    {
      include_component('limelight', 'limelightLink', array(
        'id'             => $limelight['id'],
        'pic'            => true,
      ));
    }
    ?>
  </div>
</li>