<div id="center" class="column">
  <?php if ($sf_user->hasFlash('notice')): ?>
    <div class="user_notice rnd_5"><?php echo $sf_user->getFlash('notice') ?></div>
  <?php endif; ?>
  <?php if ($sf_user->hasFlash('error')): ?>
    <div class="user_error rnd_5"><?php echo $sf_user->getFlash('error') ?></div>
  <?php endif; ?>