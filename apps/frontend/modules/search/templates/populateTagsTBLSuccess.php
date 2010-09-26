[<?php foreach ($tags as $key => $tag): ?>
[<?php echo $tag[0] ?>,"<?php echo $tag[1] ?>",null,"<div class='bs_result_item'><?php echo $tag[1] ?></div>"]<?php echo (isset($tags[$key+1]) ? ',' : '') ?>
<?php endforeach; ?>]