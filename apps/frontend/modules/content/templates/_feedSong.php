<li class="feed song" id="song_<?php echo $item['id'] ?>">
  <div class="play_score_box">
    <div class="song_play_pause play" data-file="<?php echo $item['filename'] ?>" data-song_id="<?php echo $item['id'] ?>"></div>

    <?php
    include_component('song', 'scoreBoxFull', array(
        'item_id' => $item['id'],
        'sf_cache_key' => $item['id'].'-'.($sf_user->isAuthenticated() ? $sf_user->getGuardUser()->id : 0)
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

  <div class="interact_box">
    
  </div>
</li>