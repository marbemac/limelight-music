[<?php foreach ($tags as $key => $tag): ?>
"<?php echo $tag[1] ?>"<?php echo (isset($tags[$key+1]) ? ', ' : '') ?>
<?php endforeach; ?>]