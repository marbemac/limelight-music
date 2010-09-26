<li id='ll_<?php echo $ll['id'] ?>'>
  <span class="count rnd_3"><?php echo $key+1 ?></span>
  <?php
  $link_name = $ll['name'];
  foreach ($ll['LimelightCoreSpec'] as $spec)
  {
    if ($spec['name'] == 'Manufacturer')
    {
      $link_name = $spec['content'].' '.$ll['name'];
      $break;
    }
  }
  include_partial('limelight/limelightLink', array(
    'link_name'     => $link_name,
    'route'         => 'lime_show',
    'limelight'     => $ll,
    'pic'           => true,
    'sf_cache_key'  => $ll['id'].'-pic'
  ));
  ?>
  <div class="score_increaseC rnd_2">
  +<span class='change'><?php echo (isset($ll['ll_score_increase']) ? $ll['ll_score_increase'] : '0') ?></span>
  </div>
</li>