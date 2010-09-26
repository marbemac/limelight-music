<?php slot('title', 'power search') ?>

<div class="content_panel">
  <h1>Under Construction</h1>
  <?php

  echo link_to('power search', '@power_search');
  echo link_to('power compare', '@power_compare');

  if ($type == 'filter')
    include_partial('powerFilter');
  else if ($type == 'compare')
    include_partial('powerCompare');
?>
</div>