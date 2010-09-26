<?php if (count($reviewed) >= 1): ?>

<div class="user_error">you have already reviewed this limelight</div>

<?php else: ?>

<div class="rvw_T" data-llid="<?php echo $formInfo['id'] ?>">write a review</div>

<div class="clearLeft"></div>
<div class="field_label">
  <?php echo $form['title']->renderLabel() ?>
  <div id="title_length"><span>0</span>/<?php echo sfConfig::get('app_reviews_title_max_length') ?></div>
</div>
<?php echo $form['title']->render(array('lengthIndicator' => '#title_length')) ?>

<div class="clearLeft"></div>
<div class="field_label">
  <?php echo $form['content']->renderLabel() ?>
  <div id="content_length"><span>0</span>/<?php echo sfConfig::get('app_reviews_content_max_length') ?></div>
</div>
<?php echo $form['content']->render(array('lengthIndicator' => '#content_length')) ?>

<div class="scores_C rnd_3">
  <div class="score_type">
    scoring for
    <?php 
    for ($i = 5; $i >= 0; $i--)
    {
      if (isset($formInfo['Categories'][$i])) 
      {
        echo $formInfo['Categories'][$i]['name'];
        break;
      }
    }
    ?>
  </div>
  <div class="average_D">
    * the brown vertical bars indicate the average score in the
    <?php 
    for ($i = 5; $i >= 0; $i--)
    {
      if (isset($formInfo['Categories'][$i])) 
      {
        echo $formInfo['Categories'][$i]['name'];
        break;
      }
    }
    ?>
    category
  </div>
  <div class="average_D">* the green vertical bars indicate the average score for the <?php echo $formInfo['name'] ?></div>
  <?php foreach ($formInfo['Categories'] as $key => $category): ?>
    <?php foreach ($category['CategoryScoreType'] as $key2 => $scoreType): ?>
      <div class="score" <?php if (!isset($category['CategoryScoreType'][$key2+1])) echo 'id="last"' ?>>
        <div class="score_slider_H tipBox rnd_3" tipText="<?php echo $scoreType['description'] ?>"><?php echo $scoreType['title'] ?></div>
        <div class="score_slider" data-cid="<?php echo $scoreType['id'] ?>" data-score="1">
          <?php if (isset($scoreType['LimelightReviewScoreParts'][0])): ?>
          <div class="c_avg rnd_3" title="<?php echo intval($scoreType['LimelightReviewScoreParts'][0]['average_score']) ?>"></div>
          <?php endif; ?>
          <?php if (isset($scorePartsAverage['LimelightReviewUser'][0])): ?>
          <div class="ll_avg rnd_3" title="<?php echo intval($scorePartsAverage['LimelightReviewUser'][0]['LimelightReviewScoreParts'][$key2]['average_score']) ?>"></div>
          <?php endif; ?>
        </div>
        <div class="score_slider_T sb_s rnd_3">1</div>
      </div>
    <?php endforeach; ?>
  <?php endforeach; ?>
</div>

<div class="rvw_S rnd_3" data-action="<?php echo url_for('lime_review_user_new') ?>">submit review</div>

<?php endif; ?>