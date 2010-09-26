<?php
  slot('title', sprintf('%s wiki revision %d', $revision['topics'], $revision['version']));
  //include_component('wiki', 'segmentShared', array('revision' => $revision, 'sf_cache_key' => 'revision_shared_'.$revision['group_id']))
?>

<div class="content_panel">
  <h4 class="revision_H">You are viewing the <?php echo $revision['topics'] ?> wiki segment revision <?php echo $revision['version'] ?></h4>

  <?php if ($revision['is_active']): ?>
  <div class="revision_active rnd_3">this revision is the current active version for the <?php echo $revision['topics'] ?> wiki segment</div>
  <?php else: ?>
  <div class="revision_not_active rnd_3">this revision is not the current active version for the <?php echo $revision['topics'] ?> wiki segment</div>
  <?php endif ?>

  <div class="clear"></div>
  <div class="revision wikis">
    <div class="revision_controls rnd_3">
      <div class="user">
        <?php if ($revision['user_id']): ?>
        revision submitted by
        <?php include_component('user', 'userLink', array('user_id' => $revision['user_id'], 'show_score' => true, 'pos' => 'top', 'sf_cache_key' => $revision['user_id'].'_score_top')) ?> 
        <?php else: ?>
        this revision was auto-submitted
        <?php endif ?>
      </div>
      <?php
      if ($revision['version'] != 1)
      {
        include_partial('content/flagButton', array(
            'class' => 'wiki_'.$revision['id'],
            'type' => 'fb_t',
            'target' => '.wiki_'.$revision['id'],
            'title' => 'flag this wiki revision',
            'my' => 'bottom center',
            'at' => 'top center',
            'text' => '!',
            'url' => url_for('wiki_flag_box', array('id' => $revision['id']))
          )
        );
      }
      if ($revision['edit_type'] == 'major')
      {
        include_partial('content/scoreBox', array(
              'class' => 'wiki_'.$revision['id'],
              'score' => $revision['score'],
              'type' => 'sb_s',
              'target' => '.wiki_'.$revision['id'],
              'title' => 'rate this wiki revision',
              'my' => 'bottom left',
              'at' => 'top center',
              'url' => url_for('wiki_rate_box', array('id' => $revision['id']))
        ));
      }
      ?>
      <div class="revert user_action rnd_3" title="make this the current active revision for the <?php echo $revision['topics'] ?> wiki segment" data-redirect="<?php echo url_for('wiki_history', array('group_id' => $revision['group_id'])) ?>" data-url="<?php echo url_for('wiki_revert', array('group_id' => $revision['group_id'], 'item_id' => $revision['id'])) ?>">revert</div>
    </div>
    <div class="edit rndT_3">double click on the content of the wiki below to begin editing</div>
    <?php include_partial('wiki/wikiSegment', array('wiki' => $revision)); ?>
</div>
</div>