<h2><?php echo $user->username ?> is following</h2>
<div class="sidebar_C rnd_3">
  <?php if (count($following) > 0): ?>
  <ul class="following rnd_3">
    <?php foreach ($following as $key => $following_user): ?>
      <li>
        <?php
        include_component('limelight', 'limelightLink', array(
          'id'           => $following_user['limelight_id'],
          'pic'          => true
        ));
        ?>

        <?php if ($sf_user->isAuthenticated() && $sf_user->getGuardUser()->username == $user->username): ?>
          <span class="user_action unfollow rnd_3" data-url="<?php echo url_for('Limelight_unfollow', array('id' => $following_user['limelight_id'])) ?>" title="stop following this limelight">X</span>
        <?php endif ?>
      </li>
    <?php endforeach ?>
  </ul>
  <?php else: ?>
  none
  <?php endif ?>
</div>