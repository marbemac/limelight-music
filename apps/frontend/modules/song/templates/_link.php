<?php $pos_opp = array('left' => 'right', 'bottom' => 'top', 'right' => 'left', 'top' => 'bottom') ?>

<span class="count rnd_2"><?php echo $pos ?></span>
<?php echo link_to($link['Source']['name'], $link['source_url'], array('class' => 'link filter_item top rnd_3', 'data-my' => 'bottom center', 'data-at' => 'top center', 'data-fixed' => true, 'data-type' => 'blue')) ?>
<span class="hide"><?php include_component('content', 'filterTab', array('id' => $link['id'], 'item_type' => 'NewsLink')) ?></span>
<?php
include_partial('content/scoreBox', array(
    'class' => 'news_link_'.$link['id'],
    'score' => $link['score'],
    'type' => 'sb_t',
    'target' => '.news_link_'.$link['id'],
    'title' => 'rate this news link',
    'my' => 'top center',
    'at' => 'bottom center',
    'url' => url_for('news_link_rate_box', array('id' => $link['id']))
  )
);
include_partial('content/flagButton', array(
    'class' => 'news_link_flag_'.$link['id'],
    'type' => 'fb_t',
    'target' => '.news_link_flag_'.$link['id'],
    'title' => 'flag this news link',
    'my' => 'bottom center',
    'at' => 'top center',
    'text' => '!',
    'url' => url_for('news_link_flag_box', array('id' => $link['id']))
  )
);

?>