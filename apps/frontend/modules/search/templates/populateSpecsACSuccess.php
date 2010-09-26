[<?php foreach ($specs as $key => $spec): ?>
[<?php echo $spec[0] ?>,"<?php echo $spec[1] ?>",null,"<div class='bs_result_item'><?php echo $spec[1] ?></div>"]<?php echo (isset($specs[$key+1]) ? ',' : '') ?>
<?php endforeach; ?>]