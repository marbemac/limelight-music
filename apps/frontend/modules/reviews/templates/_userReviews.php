<?php if (isset($reviews) && count($reviews) != 0): ?>
  <?php foreach ($reviews as $key => $review): ?>
  <div class="rvw_C rnd_3">
    <div class="submitby">
      submitted by 
      <?php
      include_partial('user/userLink', array(
      'user_id'     => $review['user_id'],
      'sf_cache_key' => $review['user_id']
      ));
      ?>
      on <?php echo date('M j @ g:i A', strtotime($review['created_at'])) ?>
    </div>
    <div class="rvw_top">
      <span class="rvw_score"><?php echo $review['review_score'] ?>%</span>
      <span class="title"><?php echo $review['title'] ?></span>
    </div>
    <div class="show_scores blind" blindText="hide scores" blindElem="rvw_s_<?php echo $review['id'] ?>">show scores</div>
    <div class="clearLeft"></div>
    <div class="rvw_scores_C" id="rvw_s_<?php echo $review['id'] ?>">
      <?php foreach($review['LimelightReviewScoreParts'] as $scorePart): ?>
      <div class="rvw_score_C">
        <div class="score_name"><?php echo $scorePart['CategoryScoreType']['title'] ?></div>
        <div class="score_bar"><div class="score_slot" style="left:<?php echo $scorePart['score'] ?>%"></div></div>
        <div class="score_num"><?php echo $scorePart['score'] ?>%</div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php if ($review['edited'] > 0): ?>
    <div class="updated"><?php echo 'last updated @ ' . date('M j, Y g:i a', strtotime($review['updated_at'])) ?></div>
    <?php endif; ?>
    <div id="<?php echo $review['id'] ?>" class="content rnd_3 <?php echo ($sf_user->isAuthenticated() && $sf_user->getGuardUser()->id == $review['user_id'] ? 'reviewE' : '') ?>" <?php echo ($sf_user->isAuthenticated() && $sf_user->getGuardUser()->id == $review['user_id'] ? 'contenteditable="true"' : '') ?>><?php echo html_entity_decode($review['content']) ?></div>

    <div class="sb_s <?php echo ($review['score'] < 0 ? 'sb_s_neg' : '') ?> rnd_3"><?php echo $review['score'] ?></div>
    <div class="scoreBox">
      <?php if (isset($review['scored']) && $review['scored']): ?>
      <div class="voted">voted</div>
      <?php elseif ($sf_user->isAuthenticated() && $review['user_id'] == $sf_user->GetGuardUser()->id): ?>
      <div class="voted">yours</div>
      <?php else: ?>
      <div class="plusBox rnd_3 <?php echo ($sf_user->isAuthenticated() ? 'dynamicScore' : 'authenticate') ?>" <?php if($sf_user->isAuthenticated()): ?> link="<?php echo url_for('lime_review_user_update_score', array('item_id' => $review['id'], 'target_user_id' => $review['user_id'], 'd' => 'plus')) ?>" <?php endif; ?> title="I agree - this review was helpful">+</div>
      <div class="minusBox rnd_3 <?php echo ($sf_user->isAuthenticated() ? 'dynamicScore' : 'authenticate') ?>" <?php if($sf_user->isAuthenticated()): ?> link="<?php echo url_for('lime_review_user_update_score', array('item_id' => $review['id'], 'target_user_id' => $review['user_id'], 'd' => 'minus')) ?>" <?php endif; ?> title="I disagree - this review was not helpful">-</div>
      <?php endif; ?>
    </div>
    <div class="clearLeft"></div>
  </div>

  <?php if (isset($reviews[$key + 1])): ?>
  <div class="divider"></div>
  <?php endif; ?>
  <?php endforeach; ?>
  <div id="feed_more_U" class="feed_more rnd_3" data-section="1">show more<div class="ajax_spinner"></div></div>
<?php else: ?>

<div class="noRvw">Nobody has written a review yet. Contribute and be the first!</div>

<?php endif; ?>