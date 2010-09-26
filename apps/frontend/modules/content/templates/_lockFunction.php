<?php if ($sf_user->isAuthenticated() && $sf_user->hasPermission('function_lock')): ?>

<span class="mod_action" data-url="<?php echo url_for($url, array('item_id' => $item['id'])) ?>"><?php echo $lock_text ?></span>

<?php endif; ?>