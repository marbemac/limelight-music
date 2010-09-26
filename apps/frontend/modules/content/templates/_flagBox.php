<?php
  $pos_terms = array('sweet', 'awesome', 'interesting', 'amazing', 'super', 'incredible', 'marvelous', 'cool', 'neat');
  $neg_terms = array('boring', 'stupid', 'unexciting', 'uninteresting', 'not cool');

  $terms = array (
            'LimelightSpecification' => array('Completely Incorrect', 'Out of Date', 'Duplicate', 'Spam', 'Other'),
            'Wiki' => array('Incorrect Material', 'Innapropriate', 'Spam', 'Other'),
            'News' => array('Duplicate', 'Spam', 'Innapropriate', 'Wrong Limelights', 'Other'),
            'NewsLink' => array('Duplicate', 'Broken Link', 'Spam', 'Incorrect', 'Other'),
            'Comment' => array('Spam', 'Innapropriate', 'Duplicate', 'Other'),
            'NewsTag' => array('Incorrect', 'Duplicate', 'Spam', 'Other'),
            'LimelightProCon' => array('Duplicate', 'Spam', 'Innapropriate', 'Other')
           );


  $result_data['result'] = 'success';
  $result_data['flagged'] = $flagged;
  $result_data['url'] = url_for($item_type.'_flag', array('id' => $id));
  $result_data['box_values'] = $terms[$item_type];
  echo json_encode($result_data);
?>