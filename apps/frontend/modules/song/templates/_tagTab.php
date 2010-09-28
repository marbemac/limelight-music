<div class="tag_tab">
  <?php if (isset($tag['scored'])): ?>
  <div class="scored plus <?php echo ($tag['Scores'][0]['amount'] < 0) ? 'not' : '' ?>" title="you scored this tag"></div>
  <div class="scored minus <?php echo ($tag['Scores'][0]['amount'] > 0) ? 'not' : '' ?>" title="you scored this tag"></div>
  <?php elseif ($user_id == $submitter_id): ?>
  <div class="scored plus not" title="this is your tag"></div>
  <div class="scored minus not" title="this is your tag"></div>
  <?php else: ?>
  <div class="score plus" data-action="<?php echo url_for($score_update_url, array('item_id' => $tag['id'], 'd' => 'plus')) ?>" title="this tag fits"></div>
  <div class="score minus" data-action="<?php echo url_for($score_update_url, array('item_id' => $tag['id'], 'd' => 'minus')) ?>" title="this tag doesnt fit"></div>
  <?php endif ?>
  <div class="add rnd_2" title="add this tag to your power filter">add</div>
</div>