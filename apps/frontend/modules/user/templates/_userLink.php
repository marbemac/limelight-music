<?php $pos_opp = array('left' => 'right', 'bottom' => 'top', 'right' => 'left', 'top' => 'bottom') ?>

<div class="user_link <?php echo $pos ?> user_link_<?php echo $user_id ?>">
  <?php if (isset($count) && $count != null): ?>
  <span class="count rnd_3"><?php echo $count ?></span>
  <?php endif ?>

  <a href="<?php echo url_for('user_show', array('username' => urlencode($username))) ?>" class="rnd_3" data-url="<?php echo url_for('user_tab', array('username' => urlencode($username))) ?>" data-my="<?php echo $pos_opp[$pos] ?> center" data-at="<?php echo $pos ?> center" data-type="dark"><?php echo $username ?></a>
  
  <?php if (isset($show_score)): ?>
  <span class="score rnd_3 <?php echo $scoreClass ?>"><?php echo $score ?></span>
  <?php endif ?>

  <?php if (isset($score_increase)): ?>
  <span class="score_increase rnd_3">+ <?php echo $score_increase ?></span>
  <?php endif ?>

</div>