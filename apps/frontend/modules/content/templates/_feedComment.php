<li class="feed comment rnd_3">
  <?php
  include_partial('content/scoreBox', array(
      'class' => 'comment_'.$item['id'],
      'score' => $item['score'],
      'type' => 'sb_m',
      'target' => '.comment_'.$item['id'],
      'title' => 'rate this comment',
      'my' => 'bottom center',
      'at' => 'top center',
      'url' => url_for('comment_rate_box', array('id' => $item['id']))
    )
  );
  ?>
  <div class="content">
    "
    <?php echo substr(html_entity_decode($item['content']), 0, sfConfig::get('app_comment_feed_item_length')) ?>
    <?php if (strlen($item['content']) > sfConfig::get('app_comment_feed_item_length')): ?>
    ...
    <span id="comment_<?php echo $item['id'] ?>_more" class="hide"><?php echo substr(html_entity_decode($item['content']), sfConfig::get('app_comment_feed_item_length')) ?></span>
    <?php endif ?>
    "
    <span class="toggle_more blind_new" data-target="#comment_<?php echo $item['id'] ?>_more" data-text="(hide)">(show all)</span>
    <div class="title">
      <?php
      include_component('user', 'userLink', array(
      'user_id'        => $item['user_id'],
      'show_score'     => true,
      'pos'            => 'top',
      ));
      ?>
      commented on
      <?php echo link_to($item['title'], 'news_show', array('title_slug' => $item['title_slug']), 'class=news_title') ?>
      <span class="date"><?php echo LimelightUtils::timeLapse($item['created_at']) ?></span>
    </div>
  </div>
  <div class="clear"></div>
</li>