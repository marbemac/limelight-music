<?php

$filters = $sf_user->getAttribute('filters');
$cats = json_decode($filters['c']);

$days = array('day', '3 days', 'week', 'month');
$tp = $days[$filters['ci']];

?>

<div class="fltr_section">
  <div class="fltr_item fltr_type fltr_ll rnd3_10 <?php if($filters['it'] == 'limelight') echo 'fltr_item_bg ie_g_3_10 selected' ?>" id="it=limelight">
    <div class="tl"></div><div class="tr"></div>
    limelights
    <div class="br"></div>
  </div>
  <div class="fltr_item fltr_type fltr_n rnd3_10 <?php if($filters['it'] == 'news') echo 'fltr_item_bg ie_g_3_10 selected' ?>" id="it=news">
    <div class="tl"></div><div class="tr"></div>
    news
    <div class="br"></div>
  </div>
  <div class="fltr_item fltr_type fltr_m rnd3_10 <?php if($filters['it'] == 'media') echo 'fltr_item_bg ie_g_3_10 selected' ?>" id="it=media">
    <div class="tl"></div><div class="tr"></div>
    media
    <div class="br"></div>
  </div>
  <div class="clearLeft"></div>
</div>

<div class="fltr_section">
  <div class="fltr_a_c <?php if($filters['it'] != 'all') echo 'hide' ?>">
    <div class="fltr_name">sort all by:</div>
    <div class="fltr_item fltr_item_a fltr_sb rnd3_10 <?php if($filters['it'] == 'all' && $filters['sb'] == 'score') echo 'fltr_item_bg ie_g_3_10 selected' ?>" id="sb=score">
      <div class="tl"></div><div class="tr"></div>
      score
      <div class="br"></div>
    </div>
    <div class="fltr_item fltr_item_a fltr_sb fltr_date rnd3_10 <?php if($filters['it'] == 'all' && $filters['sb'] == 'created_at') echo 'fltr_item_bg ie_g_3_10 selected' ?>" id="sb=created_at">
      <div class="tl"></div><div class="tr"></div>
      date
      <div class="br"></div>
    </div>
  </div>
  <div class="fltr_ll_c <?php if($filters['it'] != 'limelight') echo ' hide' ?>">
    <div class="fltr_name">sort limelights by:</div>
    <div class="fltr_item fltr_item_ll fltr_sb rnd3_10 <?php if($filters['it'] == 'limelight' && $filters['sb'] == 'll_score_increase') echo 'fltr_item_bg ie_g_3_10 selected' ?>" id="sb=ll_score_increase">
      <div class="tl"></div><div class="tr"></div>
      score
      <div class="br"></div>
    </div>
    <div class="fltr_item fltr_item_ll fltr_sb rnd3_10 <?php if($filters['it'] == 'limelight' && $filters['sb'] == 'll_views_increase') echo 'fltr_item_bg ie_g_3_10 selected' ?>" id="sb=ll_views_increase">
      <div class="tl"></div><div class="tr"></div>
      views
      <div class="br"></div>
    </div>
    <div class="fltr_item fltr_item_ll fltr_sb fltr_date rnd3_10 <?php if($filters['it'] == 'limelight' && $filters['sb'] == 'created_at') echo 'fltr_item_bg ie_g_3_10 selected' ?>" id="sb=created_at">
      <div class="tl"></div><div class="tr"></div>
      date
      <div class="br"></div>
    </div>
  </div>
  <div class="fltr_n_c <?php if($filters['it'] != 'news') echo ' hide' ?>">
    <div class="fltr_name">sort news by:</div>
    <div class="fltr_item fltr_item_n fltr_sb rnd3_10 <?php if($filters['it'] == 'news' && $filters['sb'] == 'news_score_increase') echo 'fltr_item_bg ie_g_3_10 selected' ?>" id="sb=news_score_increase">
      <div class="tl"></div><div class="tr"></div>
      story score
      <div class="br"></div>
    </div>
    <div class="fltr_item fltr_item_n fltr_sb rnd3_10 <?php if($filters['it'] == 'news' && $filters['sb'] == 'user_score_increase') echo 'fltr_item_bg ie_g_3_10 selected' ?>" id="sb=user_score_increase">
      <div class="tl"></div><div class="tr"></div>
      submitter score
      <div class="br"></div>
    </div>
    <div class="fltr_item fltr_item_n fltr_sb rnd3_10 <?php if($filters['it'] == 'news' && $filters['sb'] == 'news_views_increase') echo 'fltr_item_bg ie_g_3_10 selected' ?>" id="sb=news_views_increase">
      <div class="tl"></div><div class="tr"></div>
      views
      <div class="br"></div>
    </div>
    <div class="fltr_item fltr_item_n fltr_sb fltr_date rnd3_10 <?php if($filters['it'] == 'news' && $filters['sb'] == 'created_at') echo 'fltr_item_bg ie_g_3_10 selected' ?>" id="sb=created_at">
      <div class="tl"></div><div class="tr"></div>
      date
      <div class="br"></div>
    </div>
  </div>
  <div class="clearLeft"></div>
  <div id="tp_filter" class="<?php if ($filters['sb'] == 'created_at') echo 'hide' ?>">
    <div class="fltr_name">over the past:</div>
    <div class="fltr_slider_C rnd3_10 ie_g_3_10">
      <div class="tl"></div><div class="tr"></div>
      <span class="fltr_text"><?php echo $tp ?></span>
      <div class="br"></div>
    </div>
    <div class="fltr_slider tp_slider" name="<?php echo $tpCode ?>" id="tp=<?php echo $filters['tp'] ?>"></div>
  </div>
</div>

<div class="fltr_section">
  <div class="fltr_name">created in the last:</div>
  <div class="fltr_slider_C rnd3_10 ie_g_3_10">
    <div class="tl"></div><div class="tr"></div>
    <span class="fltr_text"><?php echo $ci ?></span>
    <div class="br"></div>
  </div>
  <div class="fltr_slider ci_slider" name="<?php echo $ciCode ?>" id="ci=<?php echo $filters['ci'] ?>"></div>
  <div class="clearLeft"></div>
</div>

<div class="fltr_section">
  <div class="fltr_name">filter by categories:</div>
  <div id="fltr_cat_all">
    <div class="fltr_cat_all_C rnd3_7 <?php if ($cats[0] == 0) echo 'fltr_cat_all_bg ie_7 selected' ?>">
      <div class="tl"></div><div class="tr"></div>
      show all
      <div class="br"></div>
    </div>
  </div>

  <?php foreach ($cat1 as $cat): ?>
  <?php $selected = (in_array($cat['id'], $cats) ? true : false) ?>
  <div class="fltr_cat_row">
    <div class="fltr_cat_parent rnd3_7 <?php if ($selected) echo 'fltr_cat_parent_bg ie_7 selected' ?>" id="c_<?php echo $cat['id'] ?>">
      <div class="tl"></div><div class="tr"></div>
      <?php
        echo $cat['name'];
      ?>
      <div class="br"></div>
    </div>
    <div class="fltr_cat_expand">
      <div class="fltr_cat_child_C rnd_10 ie_g_1_10 hide">
        <div class="tl"></div><div class="tr"></div>
        <?php
        foreach ($cat2 as $child) {
          if ($child['parent'] == $cat['id']) {
            $selected = (in_array($child['id'], $cats) ? true : false);
        ?>
        <div class="fltr_cat_child rnd3_7 <?php if ($selected) echo 'fltr_cat_child_bg ie_7 selected' ?>" id="c_<?php echo $child['id'] ?>">
          <div class="tl"></div>
          <div class="tr"></div>
          <?php echo $child['name'] ?>
          <div class="br"></div>
        </div>
        <?php
          }
        }
        ?>
        <div class="bl"></div><div class="br"></div>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
</div>