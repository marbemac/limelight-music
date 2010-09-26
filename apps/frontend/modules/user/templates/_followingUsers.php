<h2><?php echo $user->username ?> is following</h2>
<div class="sidebar_C rnd_3">
  <?php if (count($following) > 0): ?>
  <ul class="following rnd_3">
    <?php foreach ($following as $key => $following_user): ?>
      <li>
        <?php
        include_component('user', 'userLink', array(
          'user_id'        => $following_user['user2_id'],
          'show_score'     => true,
          'count'          => $key+1,
          'pos'            => 'left',
        ));
        ?>

        <?php if ($sf_user->isAuthenticated() && $sf_user->getGuardUser()->username == $user->username): ?>
          <span class="user_action unfollow rnd_3" data-url="<?php echo url_for('User_unfollow', array('id' => $following_user['user2_id'])) ?>" title="stop following this user">X</span>
        <?php endif ?>
      </li>
    <?php endforeach ?>
  </ul>
  <?php else: ?>
  nobody
  <?php endif ?>
</div>