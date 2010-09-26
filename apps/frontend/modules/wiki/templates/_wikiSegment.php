<a name="wiki_<?php echo $wiki['id'] ?>"></a>
<h4 class="wiki_topic rnd_3">
  <span>> </span><?php echo $wiki['topics'] ?> Wiki
</h4>
<div class="wiki rnd_3">
  <a href="<?php echo url_for('wiki_history', array('group_id' => $wiki['group_id'])) ?>" class="history rnd_3">'<?php echo $wiki['topics'] ?>' wiki history</a>
  <span class="revision">showing revision <?php echo $wiki['version'] ?></span>
  <?php if (count($wiki['LimelightWikis']) > 1): ?>
  <ul class="wiki_limelight_shared rnd_3">
    <li class="first">the <?php echo $wiki['topics'] ?> wiki segment is shared between these limelights</li>
    <?php foreach ($wiki['LimelightWikis'] as $key => $wiki_limelight): ?>
      <?php if (count($wiki['LimelightWikis']) > sfConfig::get('app_wiki_shared_list_max') && $key == sfConfig::get('app_wiki_shared_list_max')): ?>
        <li id="wiki_more_list_<?php echo $wiki['id'] ?>" class="overflow hide">
          <ul>
      <?php endif ?>
      <li>
        <?php
        include_component('limelight', 'limelightLink', array(
          'id'             => $wiki_limelight['Limelight']['id'],
          'pic'            => true
        ));
        ?>
      </li>
    <?php endforeach ?>
    <?php if (count($wiki['LimelightWikis']) > sfConfig::get('app_wiki_shared_list_max')): ?>
          </ul>
      </li>
      <li class="last blind rnd_3" blindElem="wiki_more_list_<?php echo $wiki['id'] ?>" blindText="hide extra limelights">show <?php echo count($wiki['LimelightWikis']) - sfConfig::get('app_wiki_shared_list_max') ?> more</li>
    <?php endif ?>
  <div class="clear"></div>
  </ul>
  <?php endif ?>

  <?php if ($wiki['edit_lock'] && time() - strtotime($wiki['edit_lock_time']) < sfConfig::get('app_wiki_edit_inactivity_limit')): ?>
  <div class="edit_by">
    <?php
    include_component('user', 'userLink', array(
    'user_id'        => $wiki['edit_lock_user_id'],
    'show_score'     => true,
    'sf_cache_key'   => $wiki['edit_lock_user_id'].'_score'
    ));
    ?>
    began editing this wiki section @ <?php echo date('M j, g:i:s a', strtotime($wiki['edit_lock_start'])) ?>
  </div>
  <?php endif ?>
  
  <div class="content <?php echo ($wiki['edit_lock'] && time() - strtotime($wiki['edit_lock_time']) < sfConfig::get('app_wiki_edit_inactivity_limit') ? 'edit_lock' : '') ?>" <?php echo $wiki['edit_lock'] ? 'title="this wiki section is currently being edited by another user"' : '' ?> data-inactivity="<?php echo sfConfig::get('app_wiki_edit_inactivity_limit')*1000 ?>" data-max_time="<?php echo sfConfig::get('app_wiki_edit_max_time_limit')*1000 ?>" data-url="<?php echo url_for('wiki_load_editor', array('id' => $wiki['id'])) ?>" data-update_url="<?php echo url_for('wiki_update_editor', array('id' => $wiki['id'])) ?>" data-unload_url="<?php echo url_for('wiki_unload_editor', array('id' => $wiki['id'])) ?>">
    <?php
    if ($wiki['content'])
      echo html_entity_decode($wiki['content']);
    else
      echo '<p>There are no active versions on this wiki. Help keep ' . sfConfig::get('app_site_name') . ' up to date and complete by creating a new wiki or attaching an existing wiki to this limelighti!</p>';
    ?>
  </div>

  <span class="controls hide">
    <div class="edit_type radios">
      <p>what type of edit are you making?</p>
      <span class="radio rnd_3" data-value="minor" title="a minor edit includes things such as punctuation edits, language edits, style changes, etc">minor edit</span>
      <span class="radio rnd_3" data-value="major" title="a major edit includes things such as additions or deletions, re-arrangements, etc">major edit</span>
    </div>
    <p class="note_text">edit note</p>
    <input type="text" class="note input_clear rnd_3" value="please provide a brief description of the changes you made" max-length="200" data-cleared="0" />
    <div class="submit rnd_3" data-url="<?php echo url_for('wiki_save_revision', array('id' => $wiki['id'])) ?>">save revision</div>
    <div class="cancel rnd_3" data-unload_url="<?php echo url_for('wiki_unload_editor', array('id' => $wiki['id'])) ?>">cancel and discard changes</div>
    <div class="clear"></div>
  </span>
</div>