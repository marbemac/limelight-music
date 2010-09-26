<?php
  slot('title', $user->username.' badges');
  slot('sidebar0');
    include_component('user', 'profileCard', array('user' => $user));
  end_slot();
?>

<?php include_component('user', 'notifications', array('user' => $user)) ?>
<?php include_partial('user/profileNav', array('user' => $user, 'page' => 'badge')) ?>
<div class="content_panel">
  <ul class="badge_counts">
    <?php $badge_levels = LimelightUtils::getUserBadgeLevels($user->id) ?>
    <?php for ($i=0; $i<sfConfig::get('app_badge_num_levels'); $i++): ?>
      <?php
      $badge_num = 0;
      foreach ($badge_levels as $level) {
        if ($level['level_completed'] == $i+1)
          $badge_num = $level['badge_count'];
      }
      ?>
      <li>
        <div><?php echo LimelightUtils::getBadgeName($i) ?></div>
        <img src="/images/lvl<?php echo $i+1 ?>_badge_l.jpg" alt="lvl<?php echo $i+1 ?> badges" />
        <span class="lvl_<?php echo $i+1 ?> rnd_3"><?php echo $badge_num ?></span>
      </li>
    <?php endfor ?>
  </ul>

  <p class="badge_d rnd_3">
    Earn badges by contributing to tech limelight and achieving goals. Every badge you get earns you reputation points.
  </p>

  <div class="badges_h">
    <span id="name">badge name</span>
    <span id="total">total progress</span>
    <span id="individual">individual badge progress</span>
  </div>

  <ul class="badges">
    <?php foreach ($badges as $key => $badge_obj): ?>
      <?php if ($key == 0 || $badge_obj['type'] != $badges[$key-1]['type']): ?>
        <li class="section"><?php echo $badge_obj['type'] ?></li>
      <?php endif ?>

      <li>
        <?php echo image_tag('badge_icons/'.$badge_obj['name_slug'].'_lime.jpg', array('alt' => $badge_obj['name'].' badge icon', 'class' => 'badge_icon')) ?>
        <div class="name rnd_3" title="<?php echo $badge_obj['description'] ?>"><?php echo $badge_obj['name'] ?></div>
        <div class="prog rnd_3">
          <?php echo $badge_obj['UserBadges'][0]['num_completed'].'/'.$badge_obj['BadgeLevels'][count($badge_obj['BadgeLevels'])-1]['num_required'] ?>
        </div>

        <div class="badge_prog_C">
          <?php foreach ($badge_obj['BadgeLevels'] as $key2 => $badge_level): ?>
            <div class="lvl<?php echo $badge_level['level'] ?>">
              <?php
              // iterate through all of the badge levels for each badge
              // and then check if the user has any stats for that badge
              // if user does, calculate widths for progress meter
              $prog_class = '';
              $style = '';
              $title = '';
              if ($key2 == 0)
                $prog_class .= 'rndL_3 ';
              elseif ($key2+1 == $badge_obj['UserBadges'][0]['level_completed']+1)
                $prog_class .= 'rndR_3 ';
              
              if ($key2+1 <= $badge_obj['UserBadges'][0]['level_completed'])
              {
                $prog_class .= 'complete ';
                $title = 'complete';
              }
              elseif ($key2 == $badge_obj['UserBadges'][0]['level_completed'])
              {
                if ($key2 != 0 && $badge_obj['UserBadges'][0]['num_completed'] <= $badge_obj['BadgeLevels'][$key2-1]['num_required'])
                  $style = 'width: 0%; border-right: 3px solid black;';
                else {
                  if ($key2 != 0)
                  {
                    $den = $badge_level['num_required'] - $badge_obj['BadgeLevels'][$key2-1]['num_required'];
                    $num = $badge_obj['UserBadges'][0]['num_completed'] - $badge_obj['BadgeLevels'][$key2-1]['num_required'];
                  }
                  else
                  {
                    $den = $badge_level['num_required'];
                    $num = $badge_obj['UserBadges'][0]['num_completed'];
                  }
                  $percent_complete = $num/$den*100;
                  $prog_class .= 'in_progress ';
                  $style = 'width: ' . $percent_complete . '%; border-right: 3px solid black;';
                  $title = $num . ' out of ' . $den . ' completed for this ' . LimelightUtils::getBadgeName($badge_level['level']-1) . ' badge';
                }
              }
              else
              {
                $style = 'width: 0%;';
                $prog_class += 'new';
              }
              ?>
              <div class="<?php echo $prog_class ?>" style="<?php echo $style ?>" title="<?php echo $title ?>"></div>
            </div>
          <?php endforeach ?>
        </div>
      </li>
    <?php endforeach ?>
  </ul>
</div>