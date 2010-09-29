<?php include_partial('content/layoutPart1'); ?>

<?php
slot('title', 'submit a song');
?>

<div class="content_panel contribute_item song_add">
  <h1 class="rnd_3">Submit a Song</h1>
  <h2 class="rnd_2">
    Found a song that's cool - interesting - new - or otherwise worth sharing with the world?
  </h2>
  <?php //if (!$sf_user->isAuthenticated() || !$sf_user->getGuardUser()->hasPermission('news_submit')): ?>
  <?php if (!$sf_user->isAuthenticated()): ?>
  <h2 class="dont rnd_2">
    Oops, you must be logged in and have a minimum account score of <?php echo LimelightUtils::getUserActionMinScore('submit news story') ?>
    in order to submit songs.
    <?php if ($sf_user->isAuthenticated()): ?>
    You can easily increase your account score by completing some of the simpler badges such as Autobiographer,
    Self Portrait, or Sheep.
    <br><br>
    To view your current badge progress, <?php echo link_to('click here', 'user_badgestat', array('username' => $sf_user->getGuardUser()->username)) ?>
    <?php else: ?>
    Click here to register, it's free!
    <?php endif ?>
  </h2>
  <?php else: ?>
  <h2 class="dont rnd_2">
    Try not to submit duplicate songs. Users who intentionally submit duplicate
    songs will receive a strike or possible account ban.
  </h2>
  <h2 class="error rnd_3">There were some errors - please see and correct the problems in red below. Then re-submit.</h2>

  <div id="songAdd_F" class="rnd_3">
    <?php echo $form->renderGlobalErrors() ?>
    <div class="clear" id="step1"></div>
    <h3 class="rndR_3">
      <span class="step rndL_3">1</span>info
    </h3>
    <ul class="matches rnd_3">
      <li class="first">possible song matches - make sure your song is not listed here</li>
      <div class="clear"></div>
    </ul>
    <div class="item">
      <div class="left">
        <?php echo $form['name']->renderLabel() ?>
      </div>
      <div class="right">
        <?php echo $form['name']->renderError() ?>
        <?php echo $form['name']->render() ?>
      </div>
      <div class="help rnd_2">
        <?php echo image_tag('news_add_box_arrow.gif') ?>
        Simple. The song name.
      </div>
    </div>
    <div class="clear"></div>

    <div class="item">
      <div class="left">
        <?php echo $form['content']->renderLabel() ?>
      </div>
      <div class="right">
        <?php echo $form['content']->renderError() ?>
        <?php echo $form['content'] ?>
      </div>
      <div class="help rnd_2">
        <?php echo image_tag('news_add_box_arrow.gif') ?>
        If you want to include some information about the song, this is the place. 300 characters max.
      </div>
    </div>
    <div class="clear"></div>

    <div class="item song_upload">
      <div class="left">
        <label for="song_file">Song Upload</label>
      </div>
      <div class="right">
        <input id="song_add_file" data-url="<?php echo url_for('song_upload_file') ?>" />
        <input id="song_file" name="song[filename]" type="hidden" />
        <div class="file_help rnd_2">
          Inappropriate files will earn you a strike.
        </div>
      </div>
    </div>

    <?php echo $form['_csrf_token'] ?>
    <div class="clear"></div>

    <h3 class="rndR_3">
      <span class="step rndL_3">2</span>limelights
      <div class="description">
        the limelight(s) this song is attached to - <span>at least 1 required</span>
        <?php echo image_tag('news_add_header_arrow.gif') ?>
      </div>
    </h3>
    <ul class="limelight_add_C suggest">
      <h4>possible limelight matches, click on any that fit with your story - or add your own in the box below</h4>
      <div class="clear"></div>
    </ul>
    <div class="item">
      <div class="left">
        <div class="add limelight_add rnd_3">add limelight<?php echo image_tag('news_add_limelight_arrow.gif') ?></div>
        <label for="news_limelight">Limelight</label>
      </div>
      <div class="right">
        <input type="text" id="song_limelight" name="song[limelight]" maxlength="<?php echo sfConfig::get('app_limelight_name_max_length') ?>" autocomplete="off" data-default_image_url="<?php echo sfConfig::get('app_limelight_image_path').'/thumb/limelight_profile_default.gif' ?>" data-searchloaded="" data-searchahead="<?php echo url_for('populate_limelights_ac') ?>">
      </div>
      <div class="help rnd_2">
        <?php echo image_tag('news_add_box_arrow.gif') ?>
        Input the name of the <span>artists/band/etc</span> associated with this song.
        If the limelight is listed in the drop-down, choose it from the list - try not to create a duplicate limelight.
      </div>
    </div>

    <div class="clear"></div>
    <div class="submit rnd_3" data-url="<?php echo url_for('song_add_process') ?>">submit song</div>
    <div class="clear"></div>
  </div>
  <?php endif ?>
</div>

<?php include_partial('content/layoutPart2'); ?>