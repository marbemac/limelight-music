<?php
  $terms = array (
            'Limelight' => array('favorite' => 'favorite this limelight', 'unfavorite' => 'unfavorite this limelight'),
            'News' => array('favorite' => 'favorite this news story', 'unfavorite' => 'unfavorite this news story')
           );

  $result_data['result'] = 'success';
  $result_data['url'] = url_for($item_type.'_'.$favorite, array('id' => $id));
  $result_data['value'] = $terms[$item_type][$favorite];
  echo json_encode($result_data);
?>