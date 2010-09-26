<?php if ($item['favorited']): ?>

<span class="user_action interactedButton rnd_3" data-url="<?php echo url_for($url.'_undo', array('item_id' => $item['id'], 'count' => $item['favorited_count'])) ?>" title="you and <?php echo $item['favorited_count'] - 1 ?> others have favorited this item">unfavorite - <?php echo $item['favorited_count'] ?></span>

<?php else: ?>

<span class="user_action interactPosButton rnd_3" data-url="<?php echo url_for($url, array('item_id' => $item['id'], 'count' => $item['favorited_count'])) ?>" title="Add this item to your favorites">favorite - <?php echo $item['favorited_count'] ?></span>

<?php endif; ?>