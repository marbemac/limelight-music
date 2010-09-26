[
<?php foreach ($items as $key => $item): ?>
{ "id":"<?php echo $item['id'] ?>", "topic":"<?php echo $item['topics'] ?>", "linked":"<?php echo $item['linked'] ?>", "url":"<?php echo url_for('wiki_segment', array('id' => $item['id'])) ?>", "link_url":"<?php echo $item['linked'] != '' ? url_for('wiki_segment_unlink', array('id' => $item['lw_id'])) : url_for('wiki_segment_link', array('ll_id' => $ll_id, 'group_id' => $item['group_id'])) ?>", "authorized":"<?php echo $sf_user->hasPermission('wiki_segment_unlink') ? 1 : 0 ?>" }<?php echo isset($items[$key+1]) ? ',' : '' ?>
<?php endforeach ?>
]