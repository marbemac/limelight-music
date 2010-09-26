<?php
if (!isset($filters))
  $filters = $sf_user->getAttribute('filters');

if (isset($items) && count($items) > 0) {

    if (!$section)
      echo '<ul class="feed_list">';

    foreach ($items as $item) {
        if ($type == 'Limelights') {
            include_partial('feedItemLimelight', array(
              'item' => $item,
              'filters' => $filters,
              'sf_cache_key' => $user . '-limelight-' . $item['id']
            ));
        } else if ($type == 'News') {
            $cacheKey = isset($item['scored']) ? '1' : '0';
            $cacheKey .= isset($item['flagged']) ? '1' : '0';
            $cacheKey .= isset($item['favorited']) ? '1' : '0';
            include_partial('content/feedItemNews', array(
              'item' => $item,
              'filters' => $filters
            ));
        }
    }

    if (!$section)
    {
      echo '</ul>';
      echo '<div id="feed_more" class="feed_more rnd_3" section="1">show more<div class="ajax_spinner"></div></div>';
    }

} else {
    if ($section)
        echo '0';
    else
        echo '<div class="user_error">there are currently no items matching the filters you selected</div>';
}

?>