<?php
  $pos_terms = array('is sweet', 'is awesome', 'is interesting', 'is amazing', 'is super', 'is incredible', 'is marvelous', 'is cool', 'is neat');
  $neg_terms = array('is boring', 'is stupid', 'is unexciting', 'sucks', 'is not cool');

  $terms = array (
            'LimelightSpecification' => array('pos' => 'this spec is right', 'neg' => 'this spec is wrong', 'pos_voted' => 'you said this specification is right', 'neg_voted' => 'you said this specification is wrong'),
            'Limelight' => array('pos' => 'this limelight '.$pos_terms[rand(0, count($pos_terms)-1)], 'neg' => 'this limelight '.$neg_terms[rand(0, count($neg_terms)-1)], 'pos_voted' => 'you like this limelight', 'neg_voted' => 'you don\'t like this limelight'),
            'Wiki' => array('pos' => 'this a good revision', 'neg' => 'this is a bad revision', 'pos_voted' => 'you said this is a good revision', 'neg_voted' => 'you said this is a bad revision'),
            'News' => array('pos' => 'this news story '.$pos_terms[rand(0, count($pos_terms)-1)], 'neg' => 'this news story '.$neg_terms[rand(0, count($neg_terms)-1)], 'pos_voted' => 'you like this news story', 'neg_voted' => 'you don\'t like this news story'),
            'Song' => array('pos' => 'this song '.$pos_terms[rand(0, count($pos_terms)-1)], 'neg' => 'this song '.$neg_terms[rand(0, count($neg_terms)-1)], 'pos_voted' => 'you like this song', 'neg_voted' => 'you don\'t like this song'),
            'NewsLink' => array('pos' => 'this source wrote a good article on this story', 'neg' => 'this source wrote a subpar article on this story', 'pos_voted' => 'you like the article written by this source', 'neg_voted' => 'you don\'t like the article written by this source' ),
            'Comment' => array('pos' => 'this comment is good', 'neg' => 'this comment is useless', 'pos_voted' => 'you think this is a good comment', 'neg_voted' => 'you think this comment is useless'),
            'NewsTag' => array('pos' => 'this tag relates to this story', 'neg' => 'this tag isn\'t related to this story', 'pos_voted' => 'you think this tag relates to this story', 'neg_voted' => 'you don\'t think this tag relates to this story'),
            'LimelightProCon' => array('pos' => 'I agree with this pro/con', 'neg' => 'I don\'t agree with this pro/con', 'pos_voted' => 'you agree with this pro/con', 'neg_voted' => 'you don\'t agree with this pro/con')
           );


  $result_data['result'] = 'success';
  $result_data['scored'] = $scored;
  $result_data['created_at'] = date('M j, Y', strtotime($created_at));
  $result_data['rate_up_img'] = image_tag('rateBoxUp.gif');
  $result_data['rate_down_img'] = image_tag('rateBoxDown.gif');
  $result_data['rate_up_url'] = url_for($item_type.'_update_score', array('id' => $id, 'd' => 'up'));
  $result_data['rate_down_url'] = url_for($item_type.'_update_score', array('id' => $id, 'd' => 'down'));
  $result_data['box_values'] = $terms[$item_type];
  echo json_encode($result_data);
?>