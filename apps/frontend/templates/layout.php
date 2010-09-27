<?php
  if ($sf_user->isAuthenticated() && $sf_user->getGuardUser()->Profile->status != 'Active') {
    if ($sf_user->getGuardUser()->Profile->status == 'Suspended')
      $sf_user->setFlash('notice', 'Your account has been suspended until '.$sf_user->getGuardUser()->Profile->suspend_until.'. If you feel this is an error, please contact us.');
    else if ($sf_user->getGuardUser()->Profile->status == 'Banned')
      $sf_user->setFlash('notice', 'Your account has been banned. If you feel this is an error, please contact us.');
    $sf_user->signOut();
  }

  // set the top help variable
  if ((!$sf_user->isAuthenticated() && $sf_user->getAttribute('show_help', true)) || ($sf_user->isAuthenticated() && $sf_user->getGuardUser()->show_help))
    $top_help = true;
  else
    $top_help = false;
?>

<?php use_helper('JavascriptBase'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <title><?php include_slot('title') ?> | <?php echo sfConfig::get('app_site_name') ?></title>
    <link rel="icon" href="favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
    
    <?php
    if (sfConfig::get("sf_environment") == 'prod' || sfConfig::get("sf_environment") == 'staging') {
      use_stylesheet('library.v'.sfConfig::get('app_library_css_version').'.css');
      use_stylesheet('combined.v'.sfConfig::get('app_custom_css_version').'.css');
    }
    else
    {
      use_stylesheet('jquery-ui-theme.css');
      use_stylesheet('jquery.autocomplete.css');
      use_stylesheet('uploadify.css');
      use_stylesheet('jquery.tips.css');
      use_stylesheet('main.css');
    }
    ?>

    <?php include_stylesheets() ?>
  </head>


  <?php if (!$sf_user->hasAttribute('beta_access')): ?>
  <body id="beta_body">
    <div id="container">
      <?php echo image_tag('beta_splash_logo.gif', array('id' => 'beta_splash_logo')) ?>
      <div id="beta_text">join the beta!</div>
      <input type="text" id="beta_email" class="beta_input rnd_5"></input>
      <div id="beta_store_email" class="beta_button rnd_5" data-url="<?php echo url_for('user_add_beta_email') ?>">invite me</div>
      <div id="beta_or">or</div>
      <input type="text" id="beta_access_code" class="beta_input rnd_5" value="password"></input>
      <div id="beta_access" class="beta_button rnd_5" data-url="<?php echo url_for('user_beta_access') ?>">access beta</div>
      <p id="beta_info" class="rnd_3">
        <?php echo image_tag('news_add_tag_arrow.gif') ?>
        Enter your email address to gain access to the beta during the next round of invites.
        We will <b>never</b> send you spam or share your address.
      </p>
      <div id="beta_features">
        <p class="rnd_5">
          Want a smart website? A website built for you - a seeker of all that is new and interesting in the tech world?
          Use Tech Limelight to follow the latest news on your favorite products and companies, find new products, and much more.
          This ain't your same old boring digg clone. <b>Sign up for the beta above to find out what your missing.</b>
        </p>

        <ul id="beta_switchers">
          <li class="t">feature # </li>
          <li class="rnd_3 on" data-target="#beta_feature_1">1</li>
          <li class="rnd_3" data-target="#beta_feature_2">2</li>
          <li class="rnd_3" data-target="#beta_feature_3">3</li>
          <li class="rnd_3" data-target="#beta_feature_4">4</li>
          <li class="rnd_3" data-target="#beta_feature_5">5</li>
          <li class="rnd_3 inactive" data-target="#beta_feature_6">6</li>
        </ul>

        <?php echo image_tag('beta_feature_slide1.jpg', array('id' => 'beta_feature_1', 'class' => 'feature on')) ?>
        <?php echo image_tag('beta_feature_slide2.jpg', array('id' => 'beta_feature_2', 'class' => 'feature')) ?>
        <?php echo image_tag('beta_feature_slide3.jpg', array('id' => 'beta_feature_3', 'class' => 'feature')) ?>
        <?php echo image_tag('beta_feature_slide4.jpg', array('id' => 'beta_feature_4', 'class' => 'feature')) ?>
        <?php echo image_tag('beta_feature_slide5.jpg', array('id' => 'beta_feature_5', 'class' => 'feature')) ?>
        
        <?php echo link_to('check out the new official tech limelight blog', 'http://blog.techlimelight.com', array('id' => 'beta_blog')) ?>
        <a id="beta_twitter" href="http://www.twitter.com/techlimelight"><img src="http://twitter-badges.s3.amazonaws.com/follow_me-b.png" alt="Follow techlimelight on Twitter"/></a>
        <iframe id="beta_facebook" src="http://www.facebook.com/plugins/likebox.php?id=128840593825022&amp;width=300&amp;connections=0&amp;stream=false&amp;header=false&amp;height=62" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:62px;" allowTransparency="true"></iframe>
      </div>
    </div>
    <div id="ajax_notice" class="rnd_5 hide"></div>
  <?php else: ?>

  <body class="<?php echo $top_help ? 'top_help_on' : '' ?>">
    <noscript>
      <div id="no_javascript"><?php echo sfConfig::get('app_site_name') ?> uses javascript extensively. Please enable it in your browser.</div>
    </noscript>
    <!--[if IE 6]>
    <div id="ie_6_notice">
      You're using an old version of internet explorer that <?php echo sfConfig::get('app_site_name') ?> does not currently support.
      Please consider upgrading your IE version or trying one of these alternatives:
      <ul>
        <li><a href="http://www.microsoft.com/windows/internet-explorer/default.aspx">Upgrade to internet explorer 8</a></li>
        <li><a href="http://www.mozilla.com/en-US/firefox/ie.html">Switch to mozilla firefox</a></li>
        <li><a href="http://www.apple.com/safari/">Switch to safari</a></li>
      </ul>
    </div>
    <![endif]-->

    <!--[if IE]>
    <link rel="stylesheet" type="text/css" href="/css/ie.css" />
    <![endif]-->

    <div id="wrapper">
      <div id="container">
        <div id="center" class="column">
          <?php if ($sf_user->hasFlash('notice')): ?>
            <div class="user_notice rnd_5"><?php echo $sf_user->getFlash('notice') ?></div>
          <?php endif; ?>
          <?php if ($sf_user->hasFlash('error')): ?>
            <div class="user_error rnd_5"><?php echo $sf_user->getFlash('error') ?></div>
          <?php endif; ?>
          <?php echo $sf_content ?>
          <div id="ll_ajax_spinner" class="ajax_spinner"></div>
        </div>
        <div id="right" class="column">
          <?php include_slot('sidebar0', '') ?>
          <?php include_component_slot('sidebar1') ?>
          <?php include_component_slot('sidebar2') ?>
          <?php include_component_slot('sidebar3') ?>
          <?php include_component_slot('sidebar4') ?>
          <?php include_component_slot('sidebar5') ?>
          <?php include_component_slot('sidebar6') ?>
          <?php include_component_slot('sidebar7') ?>
        </div>
      </div>
      <div id="f_wrapper">
        <div id="f" class="rnd_5">footer</div>
      </div>
      <div class="clear"></div>

      <!-- put at bottom for SEO -->
      <div id="wrapper_top_content">
        <?php include_partial('content/mainHeader') ?>
        <div id="top_advertisement"></div>
        <?php include_component('content', 'categoryRibbon') ?>
      </div>
    </div>

    <?php if ($top_help): ?>
    <div class="top_help">
      New here?  We strongly recommend you skim the <?php echo link_to('crash course', 'homepage') ?>.  Learn how you can contribute, earn points, and more!
      <span class="close rnd_3" data-url="<?php echo url_for('hide_top_help') ?>">X</span>
    </div>
    <?php endif; ?>

    <div id="authDialog"></div>
    <div id="ajax_notice" class="rnd_5 hide"></div>
    <div id="ajax_error" class="rnd_5 hide"></div>

    <?php endif; // beta splash page endif ?>

    <?php
    if (sfConfig::get("sf_environment") == 'prod' || sfConfig::get("sf_environment") == 'staging') {
      use_javascript('library.v'.sfConfig::get('app_library_js_version').'.js');

      // on which pages do we need the bloated CKE editor?
      if (($sf_context->getModuleName() == 'limelight' && $sf_context->getActionName() == 'show') || ($sf_context->getModuleName() == 'wiki' && $sf_context->getActionName() == 'revision'))
      {
        use_javascript('ckeditor/ckeditor.js');
        use_javascript('ckeditor/adapters/jquery.js');
      }

      use_javascript('combined.v'.sfConfig::get('app_custom_js_version').'.js');
    }
    else
    {
      use_javascript('json2.js');
      use_javascript('jquery.js');
      use_javascript('jquery-ui.js');

      // on which pages do we need the bloated CKE editor?
      if (($sf_context->getModuleName() == 'limelight' && $sf_context->getActionName() == 'show') || ($sf_context->getModuleName() == 'wiki' && $sf_context->getActionName() == 'revision'))
      {
        use_javascript('ckeditor/ckeditor.js');
        use_javascript('ckeditor/adapters/jquery.js');
      }

      use_javascript('jquery.scroll.js');
      use_javascript('jquery.metadata.js');
      use_javascript('idle_check.js');
      use_javascript('jquery.qtip.js');
      use_javascript('jquery.qtip.tips.js');
      use_javascript('jquery.qtip.ajax.js');
      use_javascript('swfobject.js');
      use_javascript('jquery.uploadify.js');
      use_javascript('jquery.timer.js');
      use_javascript('jquery.ajaxQueue.js');
      use_javascript('jquery.bgiframe.js');
      use_javascript('jquery.autocomplete.js');
      use_javascript('jquery.livequery.js');
      use_javascript('main.js');
    }
    ?>

    <?php include_javascripts() ?>

    <!-- for RPX login -->
    <script type="text/javascript">
      var rpxJsHost = (("https:" == document.location.protocol) ? "https://" : "http://static.");
      document.write(unescape("%3Cscript src='" + rpxJsHost +
      "rpxnow.com/js/lib/rpx.js' type='text/javascript'%3E%3C/script%3E"));
    </script>
    <script type="text/javascript">
      RPXNOW.overlay = true;
      RPXNOW.language_preference = 'en';
    </script>
    <div class="rpx_help login_C hide">
      <div class="rpx_help login rnd_5">
        We at Tech Limelight believe in <a href="http://en.wikipedia.org/wiki/KISS_principle" target="_blank">KISS</a>. Choose a provider below to login securely.
        Even mix up which provider you choose - you'll still enjoy a <span>single, seamless Tech Limelight experience</span>.
        <?php echo image_tag('rpx_login_help_arrow.gif') ?>
      </div>
    </div>
    <div class="rpx_limelight login_C hide">
      <div class="rpx_limelight login rnd_5" data-url="<?php echo url_for('signin') ?>">
        <span>or</span> click here to login directly with <?php echo sfConfig::get('app_site_name') ?>
        <?php echo image_tag('rpx_login_arrow.gif') ?>
    </div>
    </div>
    <div class="rpx_help relogin_C hide">
      <div class="rpx_help relogin rnd_5" data-url="<?php echo url_for('signin') ?>">
        You've been away for a while! For security, please verify your login below.
        <?php echo image_tag('rpx_login_help_arrow.gif') ?>
      </div>
    </div>
    <div class="rpx_help register_C hide">
      <div class="rpx_help register rnd_5">
        Why go through a tedious registration process? Why even have to remember another password?
        Here at <span>tech limelight</span> we don't think you should have to. Simply <span>login</span> using your <span>existing credentials</span>
        with any of the <span>providers</span> below and we'll create a <span>personalized tech limelight experience</span> for you!
        <?php echo image_tag('rpx_login_help_arrow.gif') ?>
      </div>
    </div>
    <div class="rpx_limelight register_C hide">
      <div class="rpx_limelight register rnd_5" data-url="<?php echo url_for('user_create') ?>">
        <span>or</span> click here to register directly with <?php echo sfConfig::get('app_site_name') ?>
        <?php echo image_tag('rpx_login_arrow.gif') ?>
      </div>
    </div>
    <!-- end RPX login -->

    <!-- for RPX publishing -->
    <script type="text/javascript">
      var rpxJsHost = (("https:" == document.location.protocol) ? "https://" : "http://static.");
      document.write(unescape("%3Cscript src='" + rpxJsHost + "rpxnow.com/js/lib/rpx.js' type='text/javascript'%3E%3C/script%3E"));
    </script>

    <script type="text/javascript">
      RPXNOW.init({appId: 'mpibekcdcbdablmnaeoh',
        xdReceiver: '/rpx_xdcomm.html'});
    </script>
    <!-- end RPX publishing -->

    <!-- START Get Satisfaction -->
<!--    <script type="text/javascript" charset="utf-8">
      var is_ssl = ("https:" == document.location.protocol);
      var asset_host = is_ssl ? "https://s3.amazonaws.com/getsatisfaction.com/" : "http://s3.amazonaws.com/getsatisfaction.com/";
      document.write(unescape("%3Cscript src='" + asset_host + "javascripts/feedback-v2.js' type='text/javascript'%3E%3C/script%3E"));
    </script>

    <script type="text/javascript" charset="utf-8">
      var feedback_widget_options = {};
      feedback_widget_options.display = "overlay";
      feedback_widget_options.company = "limelight";
      feedback_widget_options.placement = "bottom";
      feedback_widget_options.color = "#79911A";
      feedback_widget_options.style = "idea";
      var feedback_widget = new GSFN.feedback_widget(feedback_widget_options);
    </script>-->
    <!-- END Get Satisfaction -->
    
    <!-- GOOGLE ANALYTICS -->
    <script type="text/javascript">

      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-6788018-1']);
      _gaq.push(['_setDomainName', '.techlimelight.com']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();

    </script>
    <!-- END GOOGLE -->
  </body>
</html>