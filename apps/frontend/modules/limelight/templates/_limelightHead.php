<?php
  use_helper('Text');
?>

<div id="ll_head">
  <div id="ll_head_info">
    <div id="ll_head_top">
      <h1 class="name"><?php echo $limelight['company_name'] ? $limelight['company_name'].' '.$limelight['name'] : $limelight['name'] ?></h1>
      <div class="actions rnd_3">
        <?php
        include_partial('content/scoreBox', array(
            'class' => 'lime_'.$limelight['id'],
            'score' => $limelight['score'],
            'type' => 'sb_m',
            'target' => '.lime_'.$limelight['id'],
            'title' => 'rate this limelight',
            'my' => 'top center',
            'at' => 'bottom center',
            'url' => url_for('lime_rate_box', array('id' => $limelight['id']))
          )
        )
        ?>
        
        <?php include_partial('share', array('item' => $limelight)) ?>
        <?php
        include_partial('content/followButton', array(
            'class' => 'lime_follow_'.$limelight['id'],
            'target' => '.lime_follow_'.$limelight['id'],
            'title' => 'follow/unfollow '.$limelight['name'].' limelight',
            'my' => 'top center',
            'at' => 'bottom center',
            'url' => url_for('lime_follow_box', array('id' => $limelight['id']))
          )
        );
        include_partial('content/favoriteButton', array(
            'class' => 'limelight_favorite_'.$limelight['id'],
            'type' => 'favb_m',
            'target' => '.limelight_favorite_'.$limelight['id'],
            'title' => 'favorite/unfavorite the '.$limelight['name'].' limelight',
            'my' => 'top center',
            'at' => 'bottom center',
            'text' => 'favorite',
            'url' => url_for('limelight_favorite_box', array('id' => $limelight['id']))
          )
        );
        ?>
      </div>
      <div class="clearLeft"></div>
    </div>
    <div id="middle" class="rnd_3">
      <div class="toggle summary on rnd_3" data-target=".summary">summary</div>
      <div class="toggle stats rnd_3" data-target=".stats">stats</div>
      <div class="toggle charts rnd_3" data-target=".charts">charts</div>
      <div class="summary_edit rnd_3" data-url="<?php echo url_for('lime_summary_edit', array('id' => $limelight['id'])) ?>">edit summary</div>
      <div class="summary_edit_submit hide rnd_3" data-url="<?php echo url_for('lime_summary_edit', array('id' => $limelight['id'])) ?>">submit edit</div>
      <div class="summary_edit_cancel hide rnd_3">cancel edit</div>
      <div class="summary">
        <p><?php echo $limelight['Summaries'][0]['summary'] ?></p>
        <div class="user">
          originally suggested by
          <?php
          include_component('user', 'userLink', array(
            'user_id'        => $limelight['user_id'],
            'show_score'     => true,
            'pos'            => 'top',
          ));
          ?>
        </div>
      </div>
      <div class="stats hide">
        UNDER CONSTRUCTION
      </div>
      <div class="charts hide">
        <?php include_component('limelight', 'chartScoreView', array('id' => $limelight['id'], 'sf_cache_key' => $limelight['id'])) ?>
        <?php include_component('limelight', 'chartNewItems', array('id' => $limelight['id'], 'sf_cache_key' => $limelight['id'])) ?>
      </div>
    </div>
    <div id="bottom">
      <ul class="rnd_3">
        <li class="<?php echo ($page == 'info') ? 'on' : '' ?>">
          <?php
          include_component('limelight', 'limelightLink', array(
            'id'            => $limelight['id'],
            'link_name'     => 'Info',
            'pic'           => false,
            'sf_cache_key'  => $limelight['id'].'-wiki'
          ));
          ?>
        </li>
        
        <li class="<?php echo ($page == 'news') ? 'on' : '' ?>">
          <?php echo link_to('News', 'lime_show_news', array('name_slug' => $limelight['name_slug'])) ?>
          <?php if (isset($limelightStats['new_news_count']) && $limelightStats['new_news_count'] > 0): ?>
            <div class="newCount rnd_3" title="<?php echo $limelightStats['new_news_count'] ?> new news stories in the past <?php echo sfConfig::get('app_limelight_head_stat_pullback')/(60*60*24) ?> days"><?php echo $limelightStats['new_news_count'] ?></div>
          <?php endif; ?>
        </li>

        <?php if ($limelight['limelight_type'] == 'product'): ?>
        <li class="<?php echo ($page == 'reviews') ? 'on' : '' ?> future_feature">
          <?php echo link_to('Reviews', '@homepage') ?>
        </li>
        <?php endif ?>

        <?php if ($limelight['limelight_type'] == 'company'): ?>
        <li class="<?php echo ($page == 'products') ? 'on' : '' ?>">
          <?php echo link_to('Products', 'lime_show_products', array('name_slug' => $limelight['name_slug'])) ?>
          
        </li>
        <?php endif ?>

        <?php
        /* old review link
        <li class="<?php echo ($page == 'reviews') ? 'on' : '' ?>">
          <?php
          include_component('limelight', 'limelightLink', array(
            'id'            => $limelight['id'],
            'link_name'     => 'Reviews',
            'pic'           => false,
            'sf_cache_key'  => $limelight['id'].'-reviews'
          ));
          ?>
          <?php if (isset($limelightStats['new_reviews_count']) && $limelightStats['new_reviews_count'] > 0): ?>
          <div class="newCount rnd_3" title="<?php echo $limelightStats['new_reviews_count'] ?> new reviews in the past <?php echo sfConfig::get('app_limelight_head_stat_pullback')/(60*60*24) ?> days"><?php echo $limelightStats['new_reviews_count'] ?></div>
          <?php endif; ?>
        </li>
         *
         */
        ?>

        <?php if ($limelight['limelight_type'] == 'product'): ?>
        <li class="<?php echo ($page == 'media') ? 'on' : '' ?> future_feature">
          <?php echo link_to('Media', '@homepage') ?>
        </li>
        <?php endif ?>


        <li class="<?php echo ($page == 'discussion') ? 'on' : '' ?> future_feature">
          <?php echo link_to('Discussion', '@homepage') ?>
        </li>

        <?php if ($limelight['limelight_type'] == 'product'): ?>
        <li class="<?php echo ($page == 'deals') ? 'on' : '' ?> future_feature">
          <?php echo link_to('Deals', '@homepage') ?>
        </li>
        <?php endif ?>
        
        <div class="clearLeft"></div>
      </ul>
      <div class="clearLeft"></div>
    </div>
  </div>
</div>

<div id="ll_head_image_C" class="rnd_5">
  <div class="ll_head_image">
    <div class="wrapper">
      <div class="image">
        <?php echo image_tag(sfConfig::get('app_limelight_image_path') . '/med/' . $limelight['profile_image'], array('class' => 'll_profile_image')); ?>
        <div class="top"></div>
        <div class="right"></div>
        <div class="bottom"></div>
        <div class="left"></div>
      </div>
    </div>
  </div>
  <?php echo image_tag('ll_type_badge_'.$limelight['limelight_type'].'_m.gif', array('class' => 'll_type_badge')) ?>
</div>

<?php include_component('amazon', 'limelightProducts', array('limelight' => $limelight)) ?>

<div class="clearLeft"></div>
<?php include_component('limelight', 'limelightCategories', array('limelight' => $limelight, 'show_add' => true, 'sf_cache_key' => 'll_categories_'.$limelight['id'].'_add')) ?>