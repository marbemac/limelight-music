<ul class="lp-interact">
  <li class="ll">
    <div>limelights</div>
  </li>
  <li class="buy">
    <div>buy</div>
  </li>
  <li class="share">
    <div>share</div>
  </li>
  <li class="fav">
    <?php
    include_component('content', 'favorite', array(
        'item_id' => $id,
        'type' => 'Song',
        'sf_cache_key' => 'song-'.$id.'-'.($sf_user->isAuthenticated() ? $sf_user->getGuardUser()->id : 0)
      )
    );
    ?>
  </li>
  <li class="sb">
    <?php
    include_component('content', 'scoreBoxFull', array(
        'item_id' => $id,
        'type' => 'Song',
        'orientation' => 'horizontal',
        'sf_cache_key' => 'song-'.$id.'-'.($sf_user->isAuthenticated() ? $sf_user->getGuardUser()->id : 0)
      )
    );
    ?>
  </li>
  <li>
    <div>playlist</div>
  </li>
</ul>