<form class="dialog_form" action="<?php echo url_for('@signin') ?>" method="post" id="login_form">
  <?php if ($form->hasGlobalErrors()): ?>
    <?php foreach ($form->getGlobalErrors() as $error): ?>
      <div class="error"><?php echo $error ?></div>
    <?php endforeach; ?>
  <?php endif; ?>
  <label>Username or Email</label>
  <?php echo $form['username']->render(array('class' => 'field rnd_3', 'autocomplete' => 'off')); ?>
  <label>Password</label>
  <?php echo $form['password']->render(array('class' => 'field rnd_3')); ?>
  <div class="remember"><?php echo $form['remember'] ?> keep me signed in</div>
  <?php echo $form['_csrf_token'] ?>
</form>
<div class="sr_option"><?php echo link_to('> Forgot Password', '@sf_guard_password', 'id=forgot_pass') ?></div>