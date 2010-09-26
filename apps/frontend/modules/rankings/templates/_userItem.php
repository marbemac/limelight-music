<li id='user_<?php echo $user['id'] ?>'>
  <span class='count rnd_3'><?php echo $key+1 ?></span>
  <?php
    include_partial('user/userLink', array(
    'user_id'     => $user['id'],
    'sf_cache_key' => $user['id']
    ));
  ?>
  <div class="score_increaseC rnd_2">
  +<span class='change'><?php echo (isset($user['user_score_increase']) ? $user['user_score_increase'] : '0') ?></span>
  </div>
</li>