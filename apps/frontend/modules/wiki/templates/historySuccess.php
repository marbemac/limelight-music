<?php include_partial('content/layoutPart1'); ?>

<?php slot('title', sprintf('%s wiki history', $active_revision['topics'])); ?>

<?php //include_component('wiki', 'segmentShared', array('revision' => $active_revision, 'sf_cache_key' => 'wiki_shared_'.$active_revision['group_id'])) ?>

<div class="content_panel">
  <ul class="wiki_history">
    <li class="header">Current <span><?php echo $active_revision['topics'] ?></span> wiki active revision</li>
    <li class="<?php echo $active_revision['edit_type'] ?> first">
      <div class="revision">
        <div class="type"><?php echo $active_revision['edit_type'] ?></div>
        <div class="version rndT_3"><?php echo $active_revision['version'] ?></div>
      </div>
      <div class="content"><?php echo $active_revision['note'] ?></div>
      <div class="controls">
        <?php
        if ($active_revision['edit_type'] == 'major')
        {
          include_partial('content/scoreBox', array(
              'class' => 'wiki_'.$active_revision['id'],
              'score' => $active_revision['score'],
              'type' => 'sb_s',
              'target' => '.wiki_'.$active_revision['id'],
              'title' => 'rate this wiki revision',
              'my' => 'bottom center',
              'at' => 'top center',
              'url' => url_for('wiki_rate_box', array('id' => $active_revision['id']))
            )
          );
        }
        if ($active_revision['version'] != 1)
        {
          include_partial('content/flagButton', array(
              'class' => 'wiki_'.$active_revision['id'],
              'type' => 'fb_t',
              'target' => '.wiki_'.$active_revision['id'],
              'title' => 'flag this wiki revision',
              'my' => 'bottom center',
              'at' => 'top center',
              'text' => '!',
              'url' => url_for('wiki_flag_box', array('id' => $active_revision['id']))
            )
          );
        }
        ?>
        <?php if ($active_revision['user_id']): ?>
        <div class="submitted">
          submitted <?php echo LimelightUtils::timeLapse($active_revision['created_at']) ?> by
          <?php include_component('user', 'userLink', array('user_id' => $active_revision['user_id'], 'show_score' => true, 'pos' => 'top', 'sf_cache_key' => $active_revision['user_id'] . '_score_top')) ?>
        </div>
        <?php endif ?>
      </div>
      <?php if ($active_revision['is_active']): ?>
      <div class="active rndB_3">active</div>
      <?php else: ?>
      <div class="revert rndB_3">revert</div>
      <?php endif ?>
      <a href="<?php echo url_for('wiki_revision', array('item_id' => $active_revision['id'])) ?>" class="view rndB_3">view</a>
      <div class="clear"></div>
    </li>

    <li class="header"><span><?php echo $active_revision['topics'] ?></span> wiki history</li>

    <?php foreach ($revisions as $key => $revision): ?>
    <li class="<?php echo $revision['edit_type'] ?>">
      <div class="revision">
        <div class="type"><?php echo $revision['edit_type'] ?></div>
        <div class="version rndT_3"><?php echo $revision['version'] ?></div>
      </div>
      <div class="content"><?php echo $revision['note'] ?></div>
      <div class="controls">
        <?php
        if ($revision['edit_type'] == 'major')
        {
          include_partial('content/scoreBox', array(
              'class' => 'wiki_'.$revision['id'],
              'score' => $revision['score'],
              'type' => 'sb_s',
              'target' => '.wiki_'.$revision['id'],
              'title' => 'rate this wiki revision',
              'my' => 'bottom center',
              'at' => 'top center',
              'url' => url_for('wiki_rate_box', array('id' => $revision['id']))
            )
          );
        }
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
        ?>
        <?php if ($revision['user_id']): ?>
        <div class="submitted">submitted <?php echo LimelightUtils::timeLapse($revision['created_at']) ?> by <?php echo include_component('user', 'userLink', array('user_id' => $revision['user_id'], 'show_score' => true, 'pos' => 'top', 'sf_cache_key' => $revision['user_id'] . '_score_top')) ?></div>
        <?php endif ?>
      </div>
      <?php if ($revision['is_active']): ?>
      <div class="active rndB_3">active</div>
      <?php else: ?>
      <div class="revert user_action rndB_3" title="make this the current active revision for the <?php echo $revision['topics'] ?> wiki segment" data-redirect="<?php echo url_for('wiki_history', array('group_id' => $revision['group_id'])) ?>" data-url="<?php echo url_for('wiki_revert', array('group_id' => $revision['group_id'], 'item_id' => $revision['id'])) ?>">revert</div>
      <?php endif ?>
      <a href="<?php echo url_for('wiki_revision', array('item_id' => $revision['id'])) ?>" class="view rndB_3">view</a>
      <div class="clear"></div>
    </li>
    <?php endforeach ?>
  </ul>
</div>

<?php include_partial('content/layoutPart2'); ?>