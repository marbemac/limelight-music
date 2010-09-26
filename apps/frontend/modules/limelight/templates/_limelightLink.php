<div class="limelight_link">
  <?php 
  echo $sf_data->getRaw('image').link_to($link_name, 'lime_show', array('name_slug' => $limelight['name_slug']));
    
  if (isset($score) && $score != null)
  {
    include_partial('content/scoreBox', array(
                    'class' => 'lime_'.$id,
                    'score' => $score,
                    'type' => 'sb_t',
                    'target' => '.lime_'.$id,
                    'title' => 'rate this limelight',
                    'my' => $my,
                    'at' => $at,
                    'url' => url_for('lime_rate_box', array('id' => $id))
                  ));
  }
  
  echo $sf_data->getRaw('score_increase');
  ?>
</div>