<?php if (!isset($cons[$slice['id']]) || count($cons[$slice['id']]) == 0): ?>
<div  class="none slice_item slice_<?php echo $slice['id'] ?> <?php echo ($slice['id'] == 0) ? '' : 'hide' ?>">there are no cons for the <?php echo $limelight['name'] . ' ' .$slice['name'] ?> limelight</div>
<?php else: ?>
<ul class="slice_item slice_<?php echo ($cons[$slice['id']] != null) ? $slice['id'] : 0 ?> <?php echo ($slice['id'] == 0) ? '' : 'hide' ?>">
  <?php foreach($cons[$slice['id']] as $key => $con): ?>
  <?php if (count($cons[$slice['id']]) > sfConfig::get('app_limelight_procon_num') && $key == sfConfig::get('app_limelight_procon_num')): ?>
  <div id="con_more_list" class="rnd_3 hide">
  <?php endif ?>

  <li>
    <span class="key rnd_3"><?php echo $key+1 ?></span>
    <?php echo $con['name'] ?>
    <span class="actions rnd_3">
      <?php
      include_partial('content/scoreBox', array(
          'class' => 'lime_con_'.$con['id'],
          'score' => $con['score'],
          'type' => 'sb_t',
          'target' => '.lime_con_'.$con['id'],
          'title' => 'rate this con',
          'my' => 'bottom center',
          'at' => 'top center',
          'url' => url_for('lime_proscons_rate_box', array('id' => $con['id']))
        )
      );
      include_partial('content/flagButton', array(
          'class' => 'limelight_con_'.$con['id'],
          'type' => 'fb_t',
          'target' => '.limelight_con_'.$con['id'],
          'title' => 'flag this con',
          'my' => 'bottom center',
          'at' => 'top center',
          'text' => '!',
          'url' => url_for('lime_proscons_flag_box', array('id' => $con['id']))
        )
      );
      ?>
    </span>
  </li>

  <?php endforeach ?>

  <?php if (count($cons[$slice['id']]) > sfConfig::get('app_limelight_procon_num')): ?>
  </div>
  <li id="con_more" class="blind_new rnd_3" data-target="#con_more_list" data-text="hide extra cons">show <?php echo count($cons[$slice['id']]) - sfConfig::get('app_limelight_procon_num') ?> more</li>
  <?php endif ?>
</ul>
<?php endif ?>