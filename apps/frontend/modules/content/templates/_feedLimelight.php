<li class="feed limelight rnd_3">
  <?php
  include_partial('content/scoreBox', array(
      'class' => 'limelight_'.$item['id'],
      'score' => $item['score'],
      'type' => 'sb_l',
      'target' => '.limelight_'.$item['id'],
      'title' => 'rate this limelight',
      'my' => 'bottom left',
      'at' => 'top center',
      'url' => url_for('lime_rate_box', array('id' => $item['id']))
    )
  );
  ?>

  <div class="title">
    <?php
      $title = $item['company_name'].' '.$item['name'];
      if (strlen($title) > 35)
      {
        $title = substr($title, 0, 35);
        $title .= '..';
      }
    ?>
    <?php echo link_to($title, 'lime_show', array('name_slug' => $item['name_slug']), 'class=title') ?>
    <div>added <?php echo LimelightUtils::timeLapse($item['created_at']) ?></div>
  </div>

  <div class="clear"></div>

  <div class="image rnd_5">
    <div class="wrapper">
      <div class="elem">
        <?php echo image_tag(sfConfig::get('app_limelight_image_path') . '/small/' . $item['profile_image'], array('class' => 'rnd_3', '' => '', 'alt' => $item['company_name'].' '.$item['name'].' image')); ?>
      </div>
      <?php echo image_tag('ll_type_badge_'.$item['limelight_type'].'_s.gif', array('class' => 'll_type_badge')) ?>
    </div>
  </div>

  <?php  include_component('limelight', 'limelightCategories', array('limelight' => $item)) ?>
  <div class="content">
    <p class="rnd_5">
      <?php echo $item['Summaries'][0]['summary'] ?>
    </p>
  </div>

  <div class="news_box rnd_5">
    <div class="submit_by">
      originally suggested by
      <?php
      include_component('user', 'userLink', array(
      'user_id'        => $item['user_id'],
      'show_score'     => true,
      'pos'            => 'top',
      ));
      ?>
    </div>
    <div class="stat first rnd_3">
      <div class="item">views</div>
      <div class="value"><?php echo $item['total_views'] ?></div>
    </div>
    <div class="stat rnd_3">
      <div class="item">news stories</div>
      <div class="value"><?php echo count($item['Newss']) ?></div>
    </div>
    <div class="stat last rnd_3">
      <div class="item">followers</div>
      <div class="value"><?php echo count($item['Followers']) ?></div>
    </div>
    <div class="stat last rnd_3">
      <div class="item">favorited</div>
      <div class="value"><?php echo count($item['Favorited']) ?></div>
    </div>

    <div class="clear"></div>

    <?php for ($i=0; $i<2; $i++): ?>
      <?php if (isset($item['Newss'][$i])): ?>

      <div class="news <?php echo ($i == 1) ? 'last' : '' ?>">
        <div class="title">
          <?php echo link_to(substr($item['Newss'][$i]['title'], 0, 45).'...', 'news_show', array('title_slug' => $item['Newss'][$i]['title_slug'])) ?>
        </div>
        <div class="clear"></div>
        <div class="date">
          submitted <?php echo LimelightUtils::timeLapse($item['Newss'][$i]['created_at']) ?> by
          <?php
          include_component('user', 'userLink', array(
            'user_id'        => $item['Newss'][$i]['user_id'],
            'show_score'     => true,
            'pos'            => 'top',
          ));
          ?>
        </div>
        <div class="text">
          <?php echo substr($item['Newss'][$i]['content'], 0, 90); ?>...
        </div>
      </div>

      <?php
      else:
        if ($i == 0)
        {
          echo '<div class="none">There are no news stories attached to the '.$item['name'].' limelight yet</div>';
          break;
        }
        else
        {
          echo '<div class="none">There are no more news stories</div>';
          break;
        }
      endif;
      ?>
    <?php endfor ?>
  </div>
</li>