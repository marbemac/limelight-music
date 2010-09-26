<?php slot('title', 'register'); ?>

<div class="content_panel">
  <div class="form">
    <h2>Create a New Account</h2>
    <div id="r_user_url">your personal url: techlimelight.com/users/<span><?php echo ($form['username']->getValue() ? $form['username']->getValue() : '?') ?></span></div>
    <ul>
      <?php echo form_tag_for($form, '@user') ?>
        <?php foreach ($form as $field): ?>
          <li>
            <?php if($field->getName() != '_csrf_token') echo $field->renderLabel(); ?>
            <?php if($field->hasError()): ?>
              <div class="fielderror"><?php echo $field->getError(); ?></div>
            <?php endif; ?>
            <?php echo $field->render() ?>
          </li>
        <?php endforeach; ?>
          
        <div class="register_bottom">* A confirmation code will be sent to your email address.</div>
        <div>** We will NEVER share your personal information.</div>
        <input type="submit" value="register" class="submitbutton rnd_3" />
      </form>
    </ul>
  </div>
</div>