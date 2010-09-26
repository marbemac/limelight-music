<?php slot('title', 'reset password'); ?>

<div class="content_panel">
  <div class="form">
    <h2>Reset Password</h2>
    <ul>
      <form action="<?php echo url_for('user_password_reset', array('username' => $sf_request->getParameter('username'), 'code' => $sf_request->getParameter('code'))) ?>" method="POST">
        <?php if ($form->hasGlobalErrors()): ?>
          <?php foreach ($form->getGlobalErrors() as $error): ?>
            <li class="error"><?php echo $error ?></li>
          <?php endforeach; ?>
        <?php endif; ?>
        <li>
          <?php echo $form['password']->renderLabel(); ?>
          <?php if($form['password']->hasError()): ?>
            <div class="fielderror"><?php echo $form['password']->getError(); ?></div>
          <?php endif; ?>
          <?php echo $form['password']->render() ?>
        </li>
        <li>
          <?php echo $form['password2']->renderLabel(); ?>
          <?php if($form['password2']->hasError()): ?>
            <div class="fielderror"><?php echo $form['password2']->getError(); ?></div>
          <?php endif; ?>
          <?php echo $form['password2']->render() ?>
        </li>
        <li>
          <?php echo $form['code']->renderLabel(); ?>
          <?php if($form['code']->hasError()): ?>
            <div class="fielderror"><?php echo $form['code']->getError(); ?></div>
          <?php endif; ?>
          <?php echo $form['code']->render(array('value' => $sf_request->getParameter('code'))) ?>
        </li>

        <?php echo $form['username']->render(array('value' => $sf_request->getParameter('username'), 'type' => 'hidden')) ?>
        <?php echo $form['_csrf_token']->render() ?>
        <input type="submit" value="reset" class="submitbutton rnd_3" />
        
      </form>
    </ul>
  </div>
</div>