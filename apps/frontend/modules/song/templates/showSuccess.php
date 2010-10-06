<?php include_partial('content/layoutPart1'); ?>

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

  <?php include_component('content', 'feedSong', array('id' => $song['id'], 'sf_cache_key' => $song['id'])); ?>

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

<?php include_partial('content/layoutPart2'); ?>