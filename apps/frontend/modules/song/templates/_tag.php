<?php $pos_opp = array('left' => 'right', 'bottom' => 'top', 'right' => 'left', 'top' => 'bottom') ?>

<?php
include_partial('content/scoreBox', array(
    'class' => 'news_tag_score_'.$id,
    'score' => $score,
    'type' => 'sb_t',
    'target' => '.news_tag_score_'.$id,
    'title' => 'rate this news tag',
    'my' => 'bottom right',
    'at' => 'top center',
    'url' => url_for('news_tag_rate_box', array('id' => $id))
  )
);

include_partial('content/flagButton', array(
    'class' => 'news_tag_flag_'.$id,
    'type' => 'fb_t',
    'target' => '.news_tag_flag_'.$id,
    'title' => 'flag this news tag',
    'my' => 'bottom right',
    'at' => 'top center',
    'text' => '!',
    'url' => url_for('news_tag_flag_box', array('id' => $id))
  )
);
?>

<span class="tag filter_item rnd_3" data-my="<?php echo $pos_opp[$pos] ?> center" data-at="<?php echo $pos ?> center" data-type="blue"><?php echo $name ?></span>
<span class="hide"><?php include_component('content', 'filterTab', array('id' => $id, 'item_type' => 'NewsTag')) ?></span>
