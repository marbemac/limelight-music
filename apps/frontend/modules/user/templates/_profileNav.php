<ul class="user_profile_nav rnd_3">
  <li class="rnd_3">
    <?php echo link_to('minifeed', 'user_show', array('username' => $user->username), 'class=rnd_3'.($page == 'minifeed' ? ' on' : '')) ?>
  </li>
  <li class="rnd_3">
    <?php echo link_to('user feed', 'user_following', array('username' => $user->username), 'class=rnd_3'.($page == 'user_following' ? ' on' : '')) ?>
  </li>
  <li class="rnd_3">
    <?php echo link_to('limelight feed', 'lime_following', array('username' => $user->username), 'class=rnd_3'.($page == 'lime_following' ? ' on' : '')) ?>
  </li>
  <li class="rnd_3">
    <?php echo link_to('favorited', 'user_favorited', array('username' => $user->username), 'class=rnd_3'.($page == 'favorited' ? ' on' : '')) ?>
  </li>
  <li class="rnd_3">
    <?php echo link_to('badges', 'user_badge', array('username' => $user->username), 'class=rnd_3'.($page == 'badge' ? ' on' : '')) ?>
  </li>
  <li class="rnd_3">
    <?php echo link_to('stats', 'user_stat_revenue', array('username' => $user->username), 'class=rnd_3'.($page == 'stat_revenue' ? ' on' : '')) ?>
  </li>
  <?php if ($sf_user->isAuthenticated() && $sf_user->getGuardUser()->username == $user->username): ?>
    <li class="rnd_3">
      <?php echo link_to('my info', 'user_settings', array('username' => $user->username), 'class=rnd_3'.($page == 'settings' ? ' on' : '')) ?>
    </li>
  <?php endif ?>
</ul>