<div class="wiki_segment_preview">
  <h4 class="wiki_topic rnd_3"><span>> </span><?php echo $item['topics'] ?></h4>
  <?php echo html_entity_decode(substr($item->content, 0, sfConfig::get('app_wiki_segment_tooltip_max_char'))) ?>
</div>