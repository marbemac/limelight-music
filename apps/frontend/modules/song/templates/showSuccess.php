<?php
  use_helper('Text');

  slot('title', $song['name']);
  slot('sidebar0');
    //include_partial('content/tagSidebar', array('tags' => $tags, 'tagForm' => $tagForm, 'tag_lock' => $newsItem['tag_lock'], 'item_id' => $newsItem['id']));
  end_slot();
?>

<input id="song_id" disabled readonly type=hidden value="<?php echo $song['id'] ?>" />
<input id="song_name_slug" disabled readonly type=hidden value="<?php echo $song['name_slug'] ?>" />

<div class="content_panel">
  <div id="s_head">
    <?php
    if ($song['status'] == 'Active')
    {
      include_partial('content/scoreBox', array(
          'class' => 'news_'.$song['id'],
          'score' => $song['score'],
          'type' => 'sb_m',
          'target' => '.song_'.$song['id'],
          'title' => 'rate this song',
          'my' => 'top left',
          'at' => 'bottom center',
          'url' => url_for('song_rate_box', array('id' => $song['id']))
        )
      );
    }
    ?>
    <div id="s_head_name"><?php echo $song['name'] ?></div>
    <div class="clearLeft"></div>
  </div>

  <?php
  if ($song['status'] == 'Flagged'):
    echo '<div class="s_status_text">This song has been flagged for review.</div>';
  elseif ($song['status'] == 'Disabled'):
    echo '<div class="s_status_text">This song has been disabled.</div>';
  else:
  ?>
  <?php
  include_component('comment', 'showComments', array(
      'type'         => 'Song',
      'item'         => $song,
      'sf_cache_key' => 'comments_Song_'.$song['id'].'-'.$user
    ));
  ?>
  <?php endif ?>
</div>