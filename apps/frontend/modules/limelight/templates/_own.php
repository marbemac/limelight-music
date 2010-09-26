<?php

/**
 *
 *
 *
 * @version $Id$
 * @copyright 2009
 */


?>

<?php if ($stats['owner']): ?>

<span class="user_action interactedButton rnd_3" data-url="<?php echo url_for('lime_disown', array('item_id' => $stats['id'], 'count' => $stats['own_count'])) ?>" title="you have indicated that you own or use this limelight - click me to disown">owner - <?php echo $stats['own_count'] ?></span>

<?php else: ?>

<span class="user_action interactPosButton rnd_3" data-url="<?php echo url_for('lime_own', array('item_id' => $stats['id'], 'count' => $stats['own_count'])) ?>" title="do you own this product? Click me if you do.">own - <?php echo $stats['own_count'] ?></span>

<?php endif; ?>