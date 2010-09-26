<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php use_stylesheet('admin.css') ?>
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>
    <div id="container">
      <div id="header">
        <h1><?php echo sfConfig::get('app_site_name') ?></h1>
      </div>

      <?php if ($sf_user->isAuthenticated() && $sf_user->getGuardUser()->Profile->is_mod): ?>
      <div id="menu">
        <ul>
          <li><?php echo link_to('Users', 'sf_guard_user') ?></li>
          <li><?php echo link_to('Limelights', 'limelight') ?></li>
          <li><?php echo link_to('Categories', 'category') ?></li>
          <li><?php echo link_to('Logout', 'sf_guard_signout') ?></li>
        </ul>
      </div>
      <?php endif ?>

      <div class="notice"><?php echo $sf_user->hasFlash('notice') ? $sf_user->getFlash('notice') : '' ?></div>

      <div class="content">
        <?php echo $sf_content ?>
      </div>

      <div id="footer">
        footer
      </div>
    </div>
  </body>
</html>
