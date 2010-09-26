<div id="comment_c" updateAction="<?php echo url_for('comment_update') ?>" type="News">
  <div id="comment_h" class="rnd_5">
    <span id="c_count"><?php echo count($comments) ?></span> Comments
    <?php if ($item['comment_lock'] == 0 || $sf_user->hasPermission('function_lock')): ?>
    <div class="c_new rnd_5 <?php echo $sf_user->isAuthenticated() ? 'blind' : 'authenticate' ?>" blindElem="new_comment" blindText="close comment">new comment</div>
    <?php endif; ?>
    <?php if ($item['comment_lock'] == 1): ?>
    <div class="locks rnd_3">
      <div class="lock_red tipBox" tipText="Adding comments has been locked by the moderator." tipPos=",-20,-100,">C</div>
    </div>
    <?php endif; ?>
  </div>

  <?php
  if ($sf_user->hasPermission('function_lock')): ?>
  <div class="c_lock">
    <?php
    if ($item['comment_lock'] == 0)
      include_partial('content/lockFunction', array('item' => $item, 'url' => 'news_comment_lock', 'lock_text' => 'lock comment adding'));
    if ($item['comment_lock'] == 1)
      include_partial('content/lockFunction', array('item' => $item, 'url' => 'news_comment_lock', 'lock_text' => 'unlock comment adding'));
    ?>
  </div>
  <?php endif; ?>
  <?php if ($item['comment_lock'] == 0 || $sf_user->hasPermission('function_lock')): ?>
    <?php include_partial('comment/add', array('type' => $type, 'form' => $form, 'form_id' => 'new_comment', 'item_id' => $item->id, 'parent_id' => 0)) ?>
  <?php endif; ?>

  <ul class="comment_list" data-url="<?php echo url_for('comment_add_form', array('type' => $type, 'item_id' => $item->id)) ?>">
    <?php
    if ($sf_user->hasFlash('comment_0'))
      echo '<div class="comment_notice">'.$sf_user->getFlash('comment_0').'</div>';
    $position = 0;
    if (count($comments) == 0)
    {
      echo '<h3>There are no comments yet, be the first! Just click the \'new comment\' button above</h3>';
    }
    foreach ($comments as $key => $comment) {
      if ($comment['parent_id'] == null) {
        $childCount = 0;
        include_partial('comment/comment', array('comment' => $comment, 'type' => $type, 'count' => $key+1, 'lock' => $item['comment_lock'], 'age' => 'parent'));
        if ($sf_user->hasFlash('comment_'.$comment['id']))
          echo '<div class="comment_notice">'.$sf_user->getFlash('comment_'.$comment['id']).'</div>';
        for ($i=$position; $i < count($comments); $i++) {
          if ($comments[$i]['parent_id'] > $comment['id']) {
            $position = $i;
            break;
          } else if ($comments[$i]['parent_id'] == $comment['id']) {
            include_partial('comment/comment', array('comment' => $comments[$i], 'type' => $type, 'count' => ($key+1).'.'.($childCount+1), 'lock' => $item['comment_lock'], 'age' => 'child'));
            if ($sf_user->hasFlash('comment_'.$comments[$i]['id']))
              echo '<div class="comment_notice">'.$sf_user->getFlash('comment_'.$comments[$i]['id']).'</div>';
            $childCount++;
          }
        }
      }
//      foreach ($comment['Children'] as $key2 => $child)
//        
    }
    ?>
  </ul>

</div>