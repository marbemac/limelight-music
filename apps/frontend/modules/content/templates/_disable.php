<?php if ($sf_user->isAuthenticated() && $sf_user->hasPermission('disable')): ?>

<span class="mod_action" title="disable this item" data-url="<?php echo url_for($url, array('item_id' => $item['id'])) ?>">disable</span>

<?php endif; ?>