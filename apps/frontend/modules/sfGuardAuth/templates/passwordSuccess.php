<form class="dialog_form" action="<?php echo url_for('@sf_guard_password') ?>" method="post" id="forgot_pass_form">
  <?php if ($form->hasGlobalErrors()): ?>
    <?php foreach ($form->getGlobalErrors() as $error): ?>
      <div class="error"><?php echo $error ?></div>
    <?php endforeach; ?>
  <?php endif; ?>
  <label>Your Email</label>
  <?php echo $form['email']->render(array('class' => 'field rnd_3')); ?>
  <?php echo $form['_csrf_token'] ?>
</form>