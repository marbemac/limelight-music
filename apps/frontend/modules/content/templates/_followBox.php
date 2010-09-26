<?php
  $terms = array (
            'Limelight' => array('follow' => 'follow this limelight', 'unfollow' => 'stop following this limelight'),
            'User' => array('follow' => 'follow this user', 'unfollow' => 'stop following this user')
           );

  $result_data['result'] = 'success';
  $result_data['url'] = url_for($item_type.'_'.$following, array('id' => $id));
  $result_data['value'] = $terms[$item_type][$following];
  echo json_encode($result_data);
?>