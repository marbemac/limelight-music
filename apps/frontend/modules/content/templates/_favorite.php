<div class="favorite <?php echo $favorited ? 'on' : '' ?>"
     title="<?php echo $favorited ? 'click to unfavorite this item' : 'click to favorite this item' ?>"
     data-fav_url="<?php echo url_for('Song_favorite', array('id' => $item_id)) ?>"
     data-unfav_url="<?php echo url_for('Song_unfavorite', array('id' => $item_id)) ?>"></div>