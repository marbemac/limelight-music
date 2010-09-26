[<?php foreach ($users as $key => $user): ?>
{ manufacturer: "", name: "<?php echo $user[1] ?>", image: "<?php echo addslashes(image_tag(sfConfig::get('app_user_profile_path').$user[3])) ?>", score: "<?php echo $user[2] ?>", url: "<?php echo url_for('user_show', array('username' => $user[1])) ?>" }<?php echo (isset($users[$key+1]) ? ', ' : '') ?>
<?php endforeach; ?>]