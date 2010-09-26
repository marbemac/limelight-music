<div class="wiki_history_shared_C rnd_3">
  <h4>The <span><?php echo $revision['topics'] ?></span> wiki segment is shared between these limelights</h4>
  <ul class="wiki_limelight_shared rnd_3">
    <?php foreach ($shared as $key => $limelight): ?>
      <?php if (count($shared) > sfConfig::get('app_wiki_shared_list_max') && $key == sfConfig::get('app_wiki_shared_list_max')): ?>
        <li id="shared_more_list" class="overflow hide">
          <ul>
      <?php endif ?>
      <li>
        <?php
        include_component('limelight', 'limelightLink', array(
          'id'             => $limelight['id'],
          'pic'            => true
        ));
        ?>
      </li>
    <?php endforeach ?>
    <?php if (count($shared) > sfConfig::get('app_wiki_shared_list_max')): ?>
          </ul>
      </li>
      <li class="last blind rnd_3" blindElem="shared_more_list" blindText="hide extra limelights">show <?php echo count($shared) - sfConfig::get('app_wiki_shared_list_max') ?> more</li>
    <?php endif ?>
  <div class="clear"></div>
  </ul>
</div>