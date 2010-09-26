<div><?php echo image_tag('logo.png', array('absolute' => true)) ?></div>
<br />
<div><?php echo $username ?>, thanks for joining us at <?php echo sfConfig::get('app_site_name') ?>!</div>
<br />
<div>
  Please click on this
  <?php echo link_to('Validation Link', 'user_validate', array('username' => $username, 'code' => $code), array('absolute' => true)) ?>
  to activate your account.
  </div>
<br />
<div>If the link above does not work you can copy/paste the URL below directly into your browser window:</div>
<div><?php echo url_for('user_validate', array('username' => $username, 'code' => $code), array('absolute' => true)) ?></div>
<br />
<div>After activation you will have full access to <?php echo sfConfig::get('app_site_name') ?>!</div>
<br /><br />
<div>- Marc</div>
