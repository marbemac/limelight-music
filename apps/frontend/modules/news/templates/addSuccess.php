<?php
slot('title', 'submit a news story');
?>

<div class="content_panel contribute_item news_add">
  <h1 class="rnd_3">Submit a News Story</h1>
  <h2 class="rnd_2">
    Found a tech story that's cool - interesting - new - useful - or otherwise worth sharing with the world?<br><br>
    Don't fret, 3 quick steps and it's shared!
  </h2>
  <?php //if (!$sf_user->isAuthenticated() || !$sf_user->getGuardUser()->hasPermission('news_submit')): ?>
  <?php if (!$sf_user->isAuthenticated()): ?>
  <h2 class="dont rnd_2">
    Oops, you must be logged in and have a minimum account score of <?php echo LimelightUtils::getUserActionMinScore('submit news story') ?>
    in order to submit news stories. 
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
    Try not to submit duplicate stories. Users who intentionally submit duplicate 
    stories will receive a strike or possible account ban. A list of possible story
    matches (if found) will be shown after inputting your story title below.
  </h2>
  <h2 class="error rnd_3">There were some errors - please see and correct the problems in red below. Then re-submit.</h2>

  <div class="item">
    <div class="left">
      <?php echo $form['source_url']->renderLabel() ?>
    </div>
    <div class="right">
      <?php echo $form['source_url']->renderError() ?>
      <?php echo $form['source_url'] ?>
    </div>
    <div class="help rnd_2">
      <?php echo image_tag('news_add_box_arrow.gif') ?>
      The <span>full url</span> to the original story.
    </div>
  </div>
  <div class="clear"></div>
  <div class="lookup rnd_3" data-news_url="<?php echo url_for('news_lookup') ?>">look it up</div>

  <div id="newsAdd_F" class="rnd_3 hide">
    <?php echo $form->renderGlobalErrors() ?>
    <div class="clear" id="step1"></div>
    <h3 class="rndR_3">
      <span class="step rndL_3">1</span>info
      <div class="description">
        the critical story information - <span>all fields required</span>
        <?php echo image_tag('news_add_header_arrow.gif') ?>
      </div>
    </h3>
    <ul class="matches rnd_3">
      <li class="first">possible story matches - make sure a story covering the same content is not already listed here</li>
      <div class="clear"></div>
    </ul>
    <div class="item">
      <div class="left">
        <?php echo $form['title']->renderLabel() ?>
      </div>
      <div class="right">
        <?php echo $form['title']->renderError() ?>
        <?php echo $form['title']->render() ?>
      </div>
      <div class="help rnd_2">
        <?php echo image_tag('news_add_box_arrow.gif') ?>
        The story <span>title</span>. Make it <span>descriptive</span> and <span>to the point</span>.
        It does not need to be the title from the story you are linking -
        in fact, it's better to be <span>original</span>!
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
        A <span>brief synopsis</span> of the story. 300 characters max.
      </div>
    </div>
    <div class="clear"></div>

    <div class="item">
      <div class="left">
        <?php echo $form['source_name']->renderLabel() ?>
      </div>
      <div class="right">
        <?php echo $form['source_name']->renderError() ?>
        <?php echo $form['source_name']->render(array('autocomplete' => 'off')) ?>
      </div>
      <div class="help rnd_2">
        <?php echo image_tag('news_add_box_arrow.gif') ?>
        The <span>name</span> of the <span>website</span> that originally
        wrote the article. If the article points to another source as the
        original, use the referenced <span>original source</span>. Do not include www. or .com in the name.
      </div>
    </div>
    <div class="clear"></div>

    <div class="item news_image">
      <div class="left">
        <label for="news_image">Story image</label>
      </div>
      <div class="right">
        <input id="news_add_image" data-url="<?php echo url_for('news_add_upload_image') ?>" />
        <input id="news_image" name="news[news_image]" type="hidden" />
        <div class="image_help rnd_2">
          Inappropriate images will probably earn you a strike.
        </div>
      </div>
    </div>

    <?php echo $form['_csrf_token'] ?>
    <div class="clear"></div>

    <h3 class="rndR_3">
      <span class="step rndL_3">2</span>tags
      <div class="description">
        the keywords that relate to the story - <span>at least 3 required</span>
        <?php echo image_tag('news_add_header_arrow.gif') ?>
      </div>
    </h3>
    <ul class="tag_suggest suggest">
      <h4>possible tag matches, click on any that fit with your story - or add your own in the box below</h4>
    </ul>
    <ul class="tag_add_C suggest">
      <h4>your tag additions</h4>
      <div class="clear"></div>
    </ul>
    <div class="item">
      <div class="left">
        <div class="add tag_add rnd_3">add tag<?php echo image_tag('news_add_tag_arrow.gif') ?></div>
        <label for="news_tag">Tag</label>
      </div>
      <div class="right">
        <input type="text" id="news_tag" class="tag_name" name="news[tag]" maxlength="30" autocomplete="off" data-searchloaded="0" data-searchahead="<?php echo url_for('populate_tags_ac') ?>">
      </div>
      <div class="help rnd_2">
        <?php echo image_tag('news_add_box_arrow.gif') ?>
        Input a single tag at a time. Press enter after inputting each tag.
        Each tag should <span>relate</span> directly to
        what the <span>story</span> is about.
      </div>
    </div>
    <div class="clear"></div>

    <h3 class="rndR_3">
      <span class="step rndL_3">3</span>limelights
      <div class="description">
        the limelight(s) this story is about - <span>at least 1 required</span>
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
        <input type="text" id="news_limelight" name="news[limelight]" maxlength="<?php echo sfConfig::get('app_limelight_name_max_length') ?>" autocomplete="off" data-default_image_url="<?php echo sfConfig::get('app_limelight_image_path').'/thumb/limelight_profile_default.gif' ?>" data-searchloaded="" data-searchahead="<?php echo url_for('populate_limelights_ac') ?>">
      </div>
      <div class="help rnd_2">
        <?php echo image_tag('news_add_box_arrow.gif') ?>
        Input the name of the <span>primary product</span>, <span>company</span>, and/or <span>technology</span> this story is about.
        If the limelight is listed in the drop-down, choose it from the list - try not to create a duplicate limelight.
      </div>
    </div>
    
    <div class="clear"></div>
    <div class="submit rnd_3" data-url="<?php echo url_for('news_add_process') ?>">submit news story</div>
    <div class="clear"></div>
  </div>
  <?php endif ?>
</div>