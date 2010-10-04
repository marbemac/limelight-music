<div class="sb_full rnd_3">
  <div class="score_pos">
    <div class="button <?php echo $data['pos_scored'] ?>"></div>
    <div class="stat_box" title="<?php echo $data['pos_amount'] ?> likes">
      <div class="progress" style="width: <?php echo $data['pos_progress'] ?>%"></div>
    </div>
  </div>

  <div class="score"><?php echo $data['pos_amount'] + $data['neg_amount'] ?></div>

  <div class="score_neg">
    <div class="button <?php echo $data['neg_scored'] ?>"></div>
    <div class="stat_box" title="<?php echo $data['pos_amount'] ?> dislikes">
      <div class="progress" style="width: <?php echo $data['neg_progress'] ?>%"></div>
    </div>
  </div>
</div>