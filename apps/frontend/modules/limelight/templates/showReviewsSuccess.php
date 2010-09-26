<?php
slot('title', sprintf('%s Reviews | Tech Limelight', $limelight['name']));

use_stylesheet('reviews');
use_javascript('reviews');
use_javascript('editable.js');

if ($sf_user->isAuthenticated() && ($sf_user->hasGroup('admin') || $sf_user->hasGroup('moderator2')))
    $cacheKey = 'mod';
  else
    $cacheKey = 'user';

  include_component('limelight', 'limelightHead', array('limelight' => $limelight, 'limelightStats' => $limelightStats, 'page' => 'reviews', 'sf_cache_key' => 'll_id='.$limelight->id.'&group='.$cacheKey.'&page=reviews'));
?>

<div class="clearLeft"><br /></div>

<?php if (!$reviewsUserFlag): ?>
  <div class="user_error">User reviews cannot be submitted until <?php echo (sfConfig::get('app_reviews_enable_user_date') / 24 / 60 / 60) ?> days before the <?php echo $limelight->name ?> release date</div>
<?php endif; ?>
<?php if (!$reviewsProFlag): ?>
  <div class="user_error">Professional reviews cannot be linked until <?php echo (sfConfig::get('app_reviews_enable_pro_date') / 24 / 60 / 60) ?> days before the <?php echo $limelight->name ?> release date</div>
<?php endif; ?>

<div id="review_C">
  <div class="rvws_uC" data-action="<?php echo url_for('lime_review_user_update') ?>">
    <div class="T">
      what you're saying
      <?php if ($limelight['review_user_count'] != 0): ?>
      <span><?php echo $limelight['review_user_count'] ?> review(s)</span>
      <?php endif; ?>
    </div>

    <div class="scoreBarC rnd_3">
      <div class="scoreBar rnd_3" w_score="<?php echo ($limelight['review_user_weighted_average'] != null ? $limelight['review_user_weighted_average'] : '0') ?>" s_score="<?php echo ($limelight['review_user_average'] != null ? $limelight['review_user_average'] : '0') ?>"></div>
    </div>
    <div class="scoreText"><?php echo ($limelight['review_user_average'] != null ? $limelight['review_user_average'].'%' : 'N/A'); ?></div>

    <?php if ($reviewsUserFlag): ?>
      <?php if ($limelight['review_user_count'] != 0): ?>
      <div class="scoreWeight_on tipBox rnd_2" tipText="score is calculated as a simple average">straight score</div>
      <div class="scoreWeight tipBox rnd_2" tipText="score is calculated based on a weighted average<br/><br/>reviews with a higher community score affect the weighted average more than reviews with a lower community score<br/><br/>this measurement combines the review scores themselves with how much the community agrees with the reviews">weighted score</div>
      <?php endif; ?>

      <div class="rvw_controls">
        <div class="rvwContributeB <?php echo $sf_user->isAuthenticated() ? 'reviewB' : 'authenticate' ?>" data-action="<?php echo url_for('lime_review_user_new', array('ll_id' => $limelight['id'])) ?>">contribute</div>
        <div class="clearLeft"></div>
        <?php if ($limelight['review_user_count'] > 0): ?>
        <div class="sortT">or sort by</div>
        <div class="review_sort sort_on" data-action="<?php echo url_for('lime_review_user_ajax', array('ll_id' => $limelight['id'], 'o' => 0)) ?>">date</div>
        <div class="review_sort" data-action="<?php echo url_for('lime_review_user_ajax', array('ll_id' => $limelight['id'], 'o' => 1)) ?>">score</div>
        <div class="review_sort" data-action="<?php echo url_for('lime_review_user_ajax', array('ll_id' => $limelight['id'], 'o' => 2)) ?>">user score</div>
        <div class="review_sort" data-action="<?php echo url_for('lime_review_user_ajax', array('ll_id' => $limelight['id'], 'o' => 3)) ?>">most helpful</div>
        <div class="review_sort" data-action="<?php echo url_for('lime_review_user_ajax', array('ll_id' => $limelight['id'], 'o' => 4)) ?>">least helpful</div>
        <div class="clearLeft"></div>
        <?php endif; ?>
      </div>

      <div class="rvws_U">
        <?php include_component('reviews', 'userReviews', array('ll_id' => $limelight->id, 'sf_cache_key' => 'll_id='.$limelight->id.'&user_id='.$user_id)); ?>
      </div>
    <?php endif; ?>
  </div>

  <div class="rvws_pC">
    <div class="T">
      what they're saying
      <?php if ($limelight['review_pro_count'] != 0): ?>
      <span><?php echo $limelight['review_pro_count'] ?> review(s)</span>
      <?php endif; ?>
    </div>

    <div class="scoreBarC rnd_3">
      <div class="scoreBar rnd_3" w_score="<?php echo ($limelight['review_pro_weighted_average'] != null ? $limelight['review_pro_weighted_average'] : '0') ?>" s_score="<?php echo ($limelight['review_pro_average'] != null ? $limelight['review_pro_average'] : '0') ?>"></div>
    </div>
    <div class="scoreText"><?php echo ($limelight['review_pro_average'] != null ? $limelight['review_pro_average'].'%' : 'N/A'); ?></div>

    <?php if ($reviewsProFlag): ?>
      <?php if ($limelight['review_pro_count'] != 0): ?>
      <div class="scoreWeight_on tipBox rnd_2" tipText="score is calculated as a simple average">straight score</div>
      <div class="scoreWeight tipBox rnd_2" tipText="score is calculated based on a weighted average<br/><br/>reviews with a higher community score affect the weighted average more than reviews with a lower community score<br/><br/>this measurement combines the review scores themselves with how much the community agrees with the reviews">weighted score</div>
      <?php endif; ?>

      <div class="rvws_P">
        <?php include_component('reviews', 'proReviews', array('limelight' => $limelight, 'sf_cache_key' => 'll_id='.$limelight->id.'&user_id='.$user_id)); ?>
      </div>
    <?php endif; ?>
  </div>
</div>
