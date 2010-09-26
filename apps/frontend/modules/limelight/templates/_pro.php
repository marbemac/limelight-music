<?php if (!isset($pros[$slice['id']]) || count($pros[$slice['id']]) == 0): ?>
<div class="none slice_item slice_<?php echo $slice['id'] ?> <?php echo ($slice['id'] == 0) ? '' : 'hide' ?>">there are no pros for the <?php echo $limelight['name'] . ' ' .$slice['name'] ?> limelight</div>
<?php else: ?>
<ul class="slice_item slice_<?php echo ($pros[$slice['id']] != null) ? $slice['id'] : 0 ?> <?php echo ($slice['id'] == 0) ? '' : 'hide' ?>">
  <?php foreach($pros[$slice['id']] as $key => $pro): ?>

  <?php if (count($pros[$slice['id']]) > sfConfig::get('app_limelight_procon_num') && $key == sfConfig::get('app_limelight_procon_num')): ?>
  <div id="pro_more_list" class="rnd_3 hide">
  <?php endif ?>

  <li>
    <span class="key rnd_3"><?php echo $key+1 ?></span>
    <?php echo $pro['name'] ?>
    <span class="actions rnd_3">
      <?php
      include_partial('content/scoreBox', array(
          'class' => 'lime_pro_'.$pro['id'],
          'score' => $pro['score'],
          'type' => 'sb_t',
          'target' => '.lime_pro_'.$pro['id'],
          'title' => 'rate this pro',
          'my' => 'bottom center',
          'at' => 'top center',
          'url' => url_for('lime_proscons_rate_box', array('id' => $pro['id']))
        )
      );
      include_partial('content/flagButton', array(
          'class' => 'limelight_pro_'.$pro['id'],
          'type' => 'fb_t',
          'target' => '.limelight_pro_'.$pro['id'],
          'title' => 'flag this pro',
          'my' => 'bottom center',
          'at' => 'top center',
          'text' => '!',
          'url' => url_for('lime_proscons_flag_box', array('id' => $pro['id']))
        )
      );
      ?>
    </span>
  </li>

  <?php endforeach ?>

  <?php if (count($pros[$slice['id']]) > sfConfig::get('app_limelight_procon_num')): ?>
  </div>
  <li id="pro_more" class="blind_new rnd_3" data-target="#pro_more_list" data-text="hide extra pros">show <?php echo count($pros[$slice['id']]) - sfConfig::get('app_limelight_procon_num') ?> more</li>
  <?php endif ?>
</ul>
<?php endif ?>