<div class="sb_full rnd_3">
  <div class="score_pos <?php echo $orientation ?>">
    <div class="button <?php echo $data['pos_scored'] ?>" data-url="<?php echo url_for($type.'_update_score', array('id' => $item_id, 'd' => 'up')) ?>"></div>
    
    <?php if ($orientation == 'vertical'): ?>
    <div class="stat_box" title="<?php echo $data['pos_amount'] ?> likes">
      <div class="progress" style="width: <?php echo $data['pos_progress'] ?>%"></div>
    </div>
    <?php endif ?>

  </div>

  <div class="score rnd_3"><?php echo $data['pos_amount'] + $data['neg_amount'] ?></div>

  <div class="score_neg <?php echo $orientation ?>">
    <div class="button <?php echo $data['neg_scored'] ?>" data-url="<?php echo url_for($type.'_update_score', array('id' => $item_id, 'd' => 'down')) ?>"></div>
    
    <?php if ($orientation == 'vertical'): ?>
    <div class="stat_box" title="<?php echo $data['neg_amount'] ?> dislikes">
      <div class="progress" style="width: <?php echo $data['neg_progress'] ?>%"></div>
    </div>
    <?php endif ?>

  </div>
</div>