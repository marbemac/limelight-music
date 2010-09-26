<?php if (!isset($specifications[$slice['id']]) || count($specifications[$slice['id']]) == 0): ?>
<div class="none specs slice_item slice_<?php echo $slice['id'] ?> <?php echo $slice['id'] == 0 ? '' : 'hide' ?>">there are no <?php echo $spec_requirements_check ?>s for <?php echo $spec_requirements_check == 'specification' ? 'the' : '' ?> <?php echo $limelight['name'] . ' ' . $slice['name'] ?> yet - try adding one by clicking on the 'add a <?php echo $spec_requirements_check ?>' button above</div>
<?php else: ?>

  <ul class="specs slice_item slice_<?php echo $slice['id'] ?> <?php echo $slice['id'] == 0 ? '' : 'hide' ?>">
    <?php foreach ($specifications[$slice['id']] as $spec): ?>
    <?php if (count($specifications[$slice['id']]) > sfConfig::get('app_spec_lime_max') && $key == sfConfig::get('app_spec_lime_max')): ?>
      <div id="spec_more_list" class="hide">
    <?php endif ?>
    <li>
      <span class="name rnd_3"><span class="expand rnd_3">+</span><?php echo $spec['name'] ?></span>
      <span class="content"><?php echo $spec['content'] ?></span>
      <div class="clear"></div>
      <span class="extra hide">
      <span class="name">Source:</span>
      <span class="content"><a href="<?php echo $spec['source_url'] ?>" rel="nofollow"><?php echo $spec['Source']['name'] ?></a></span>
      <div class="clear"></div>
      <div class="bottom">
        <span class="actions">
          <?php
          include_partial('content/scoreBox', array(
              'class' => 'lime_spec_'.$spec['id'],
              'score' => $spec['score'],
              'type' => 'sb_t',
              'target' => '.lime_spec_'.$spec['id'],
              'title' => 'rate this specification',
              'my' => 'top left',
              'at' => 'bottom center',
              'url' => url_for('lime_specification_rate_box', array('id' => $spec['id']))
            )
          );
          include_partial('content/flagButton', array(
              'class' => 'limelight_specification_'.$spec['id'],
              'type' => 'fb_t',
              'target' => '.limelight_specification_'.$spec['id'],
              'title' => 'flag this specification',
              'my' => 'top left',
              'at' => 'bottom center',
              'text' => '!',
              'url' => url_for('lime_specification_flag_box', array('id' => $spec['id']))
            )
          );
          ?>
        </span>
        <div class="user">
          <?php
          include_component('user', 'userLink', array(
            'user_id'        => $spec['user_id'],
            'show_score'     => true,
            'pos'            => 'top',
          ));
          ?>
          added - <?php echo date('M j, y', strtotime($spec['created_at'])) ?>
        </div>
      </div>
      <div class="clear"></div>
      </span>
    </li>
    <?php endforeach ?>
  <?php if (count($specifications[$slice['id']]) > sfConfig::get('app_spec_lime_max')): ?>
    </div>
    <li class="spec_more blind_new rnd_3" data-target="#spec_more_list" data-text="hide extra specs">show <?php echo count($specifications[$slice['id']]) - sfConfig::get('app_spec_lime_max') ?> more</li>
  <?php endif ?>
  </ul>
<?php endif ?>