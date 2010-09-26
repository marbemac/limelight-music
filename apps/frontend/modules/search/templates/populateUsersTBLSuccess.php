[<?php foreach ($users as $key => $user): ?>
[<?php echo $user[0] ?>,"<?php echo $user[1] ?>",null,"<div class='bs_result_item'><?php echo addslashes(image_tag(sfConfig::get('app_user_profile_image_path').$user[3]).'<span>'.$user[1].'</span><span class=\'sb_s rnd_3\'>'.$user[2].'</span>') ?></div>"]<?php echo (isset($users[$key+1]) ? ',' : '') ?>
<?php endforeach; ?>]

