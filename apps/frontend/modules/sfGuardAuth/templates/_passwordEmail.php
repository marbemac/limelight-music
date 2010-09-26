<div><?php echo image_tag('logo.png', array('absolute' => true)) ?></div>
<br />
<div><?php echo $username ?>, you have requested a password reset.</div>
<br />
<div>
  Please click on this
  <?php echo link_to('Reset Link', 'user_password_reset', array('username' => $username, 'code' => $code), array('absolute' => true)) ?>
  to reset your password.
  </div>
<br />
<div>If the link above does not work you can copy/paste the URL below directly into your browser window:</div>
<div><?php echo url_for('user_password_reset', array('username' => $username, 'code' => $code), array('absolute' => true)) ?></div>
<br />
<div>Should you have any problems, please contact us via the contact form on the website.</div>
<br /><br />
<div>- Marc</div>
