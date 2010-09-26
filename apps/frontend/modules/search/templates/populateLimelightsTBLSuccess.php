[<?php foreach ($limelights as $key => $limelight): ?>
[<?php echo $limelight[0] ?>,"<?php echo ($limelight[4] ? $limelight[4].' '.$limelight[1] : $limelight[1]) ?>","<?php echo $limelight[1] ?>","<div class='bs_result_item'><?php echo addslashes(image_tag(sfConfig::get('app_limelight_profile_path').$limelight[3]).'<span>'.$limelight[4].' '.$limelight[1].'</span><span class=\'sb_s rnd_3\'>'.$limelight[2].'</span>') ?></div>"]<?php echo (isset($limelights[$key+1]) ? ',' : '') ?>
<?php endforeach; ?>]

