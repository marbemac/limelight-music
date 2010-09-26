<li id="c_<?php echo $comment['id'] ?>" class="<?php echo $type ?> <?php echo $age ?> rnd_5 <?php if ($comment['score'] <= sfConfig::get('app_comment_dim_val')) echo 'dimmed' ?>">
  <div class="count <?php echo $age ?>"><?php echo $count ?></div>
  <div class="info">
    <?php echo image_tag(sfConfig::get('app_user_profile_image_path').'/small/'.$comment['User']['Profile']['profile_image'], array('class' => 'u_profile_img '.$age)); ?>
    <div class="submit_by">
      <?php
      include_component('user', 'userLink', array(
        'user_id'        => $comment['User']['id'],
        'show_score'     => true,
        'pos'            => 'top',
        'count'          => null,
        'score_increase' => null
      ));
      ?>
      <span class="submit_date"><?php echo LimelightUtils::timeLapse($comment['created_at']) ?></span>
    </div>
    <div data-id="<?php echo $comment['id'] ?>" class="content <?php //echo ($sf_user->getGuardUser()->id == $comment['User']['id'] && $lock == 0 && $comment['edited'] < sfConfig::get('app_comment_max_edited') ? 'commentE' : '') ?>">
      <?php echo html_entity_decode($comment['content']) ?>
    </div>
    <?php if ($comment['edited'] > 0): ?>
      <div class="updated">last updated <?php echo LimelightUtils::timeLapse($comment['created_at']) ?></div>
    <?php endif; ?>
  </div>
  <div class="actions">
    <?php include_partial('content/disable', array('item' => $comment, 'url' => 'comment_disable')); ?>
    <?php
    include_partial('content/scoreBox', array(
        'class' => 'comment_'.$comment['id'],
        'score' => $comment['score'],
        'type' => 'sb_s',
        'target' => '.comment_'.$comment['id'],
        'title' => 'rate this comment',
        'my' => 'bottom center',
        'at' => 'top center',
        'url' => url_for('comment_rate_box', array('id' => $comment['id']))
      )
    );
    include_partial('content/flagButton', array(
        'class' => 'news_comment_flag_'.$comment['id'],
        'type' => 'fb_t',
        'target' => '.news_comment_flag_'.$comment['id'],
        'title' => 'flag this comment',
        'my' => 'bottom center',
        'at' => 'top center',
        'text' => '!',
        'url' => url_for('comment_flag_box', array('id' => $comment['id']))
      )
    );
    ?>
    <?php if ($lock == 0 || $sf_user->hasPermission('function_lock')): ?>
      <?php if (!$sf_user->isAuthenticated() || $comment['user_id'] != $sf_user->GetGuardUser()->id): ?>
        <div class="reply rnd_3 <?php echo ($sf_user->isAuthenticated() ? 'addComment' : 'authenticate') ?>" data-id="<?php echo $comment['parent_id'] == NULL ? $comment['id'] : $comment['parent_id'] ?>">reply</div>
      <?php endif ?>
    <?php endif; ?>
  </div>
  <div class="clear"></div>
</li>