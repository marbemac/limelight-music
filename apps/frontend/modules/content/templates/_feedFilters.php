<?php
$filters = $sf_user->getAttribute('filters');
?>

<div class="feed_filter">
  <div class="header">showing </div>
  <div class="filter_group feed_type rnd_5">
    <a href="<?php echo url_for('feed_song_category', array('category' => $sf_params->get('category', ''))) ?>" class="news rnd3_5 <?php echo $filters['feed_type'] == 'Song' ? 'on' : 'hide' ?>" data-value="Song">songs</a>
    <a href="<?php echo url_for('feed_limelight_category', array('category' => $sf_params->get('category', ''))) ?>" class="limelight rnd3_5 <?php echo $filters['feed_type'] == 'Limelight' ? 'on' : 'hide' ?>" data-value="Limelight">limelights</a>
  </div>

  <div class="header">sorted by</div>
  <div class="filter_group sort_by rnd_5">
    <div class="popularity rnd3_5 <?php echo $filters['sort_by'] == 'popularity' ? 'on' : 'hide' ?>" data-value="popularity">popularity</div>
    <div class="created rnd3_5 <?php echo $filters['sort_by'] == 'created' ? 'on' : 'hide' ?>" data-value="created">newest</div>
  </div>

  <div class="header <?php echo $filters['sort_by'] == 'created' ? 'hide' : '' ?>">over the past</div>
  <div class="filter_group time_period <?php echo $filters['sort_by'] == 'created' ? 'hide' : '' ?> rnd_5">
    <div class="rnd3_5 <?php echo $filters['time_period'] == 1 ? 'on' : 'hide' ?>" data-value="1">day</div>
    <div class="rnd3_5 <?php echo $filters['time_period'] == 3 ? 'on' : 'hide' ?>" data-value="3">few days</div>
    <div class="rnd3_5 <?php echo $filters['time_period'] == 7 ? 'on' : 'hide' ?>" data-value="7">week</div>
    <div class="rnd3_5 <?php echo $filters['time_period'] == 30 ? 'on' : 'hide' ?>" data-value="30">month</div>
  </div>
  <div class="clear"></div>
</div>