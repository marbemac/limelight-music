<li id='news_<?php echo $news['id'] ?>'>
  <span class="count rnd_3"><?php echo $key+1 ?></span>
  <?php
  include_partial('news/newsLink', array(
    'item'         => $news,
    'sf_cache_key' => $news['id']
  ));
  ?>
  <div class="score_increaseC rnd_2">
  +<span class='change'><?php echo (isset($news['news_score_increase']) ? $news['news_score_increase'] : '0') ?></span>
  </div>
</li>