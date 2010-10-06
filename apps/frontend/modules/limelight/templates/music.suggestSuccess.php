<?php include_partial('content/layoutPart1'); ?>

<?php
slot('title', 'suggest a limelight');
?>

<div class="content_panel contribute_item limelight_suggest">
  <h1 class="rnd_3">Suggest a Limelight</h1>
  <h2 class="rnd_2">
    Want to instantly create a page dedicated to intelligently aggregating, sorting, and displaying user contributed content
    about your favorite tech product or technology? Get started below!
  </h2>
  <?php //if (!$sf_user->isAuthenticated() || !$sf_user->getGuardUser()->hasPermission('limelight_suggest')): ?>
  <?php if (!$sf_user->isAuthenticated()): ?>
  <h2 class="dont rnd_2">
    Oops, you must be logged in and have a minimum account score of <?php echo LimelightUtils::getUserActionMinScore('suggest a limelight') ?>
    in order to suggest limelights.
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
  <h2 class="error rnd_3">There were some errors - please see and correct the problems in red below. Then re-submit.</h2>
  <div id="limelightSuggest_F" class="rnd_3">
    <?php echo $form->renderGlobalErrors() ?>
    <div class="clear" id="step1"></div>
    
    <ul class="matches rnd_3">
      <li class="first">possible limelight matches - make sure the limelight you are submitting is not already listed here</li>
      <div class="clear"></div>
    </ul>

    <div class="item types hide">
      <div class="left"><label>limelight type</label></div>
      <div class="right">
        <div class="product on">artist</div>
      </div>
    </div>

    <div class="item category_chooser">
      <div class="left"><label>category</label></div>
      <div class="right">
        <select class="rndR_3 cat1">
          <option value=""></option>
          <?php foreach ($categories as $cat1): ?>
          <?php if ($cat1['parent_id'] == null): ?>
          <option value="<?php echo $cat1['id'] ?>"><?php echo $cat1['name'] ?></option>
          <?php endif ?>
          <?php endforeach ?>
        </select>

        <?php foreach ($categories as $cat1): ?>
          <?php if ($cat1['parent_id'] == null): ?>
          <select class="rnd_3 cat2 hide" id="cat_select_<?php echo $cat1['id'] ?>">
            <option value=""></option>
            <?php foreach ($cat1['Children'] as $cat2): ?>
            <option value="<?php echo $cat2['id'] ?>"><?php echo $cat2['name'] ?></option>
            <?php endforeach ?>
          </select>
          <?php endif ?>
        <?php endforeach ?>

        <?php foreach ($categories as $cat1): ?>
          <?php if ($cat1['parent_id'] == null): ?>
          <?php foreach ($cat1['Children'] as $cat2): ?>
          <?php if (count($cat2['Children']) > 0): ?>
          <select class="rnd_3 cat3 hide" id="cat_select_<?php echo $cat2['id'] ?>">
            <option value=""></option>
            <?php foreach ($cat2['Children'] as $cat3): ?>
            <option value="<?php echo $cat3['id'] ?>"><?php echo $cat3['name'] ?></option>
            <?php endforeach ?>
          </select>
          <?php endif ?>
          <?php endforeach ?>
          <?php endif ?>
        <?php endforeach ?>

      </div>
      <div class="help rnd_2">
        Select the most specific category that this limelight fits into
      </div>
    </div>

    <div class="item">
      <div class="left">
        <?php echo $form['name']->renderLabel() ?>
      </div>
      <div class="right">
        <?php echo $form['name']->renderError() ?>
        <?php echo $form['name']->render(array('data-url' => url_for('lime_check'))) ?>
      </div>
      <div class="help rnd_2">
        <?php echo image_tag('news_add_box_arrow.gif') ?>
        The <span>name</span> of the limelight. If the limelight is a product and does not have a name, the <span>model number</span>
        should be used. <br><br>e.g. iPhone 3G, Wii, Apple, Engadget, LCD, LN46A950
      </div>
    </div>
    <div class="clear"></div>

    <div class="item company hide">
      <div class="left">
        <?php echo $form['company_name']->renderLabel() ?>
      </div>
      <div class="right">
        <?php echo $form['company_name']->renderError() ?>
        <?php echo $form['company_name']->render(array('data-searchloaded' => '', 'data-searchahead' => url_for('populate_lime_companies_ac'))) ?>
      </div>
      <div class="help rnd_2">
        <?php echo image_tag('news_add_box_arrow.gif') ?>
        Who <span>makes, develops, or publishes the product</span>? <br><br>e.g. Sony, Apple, Microsoft, Bioware, Samsung
      </div>
    </div>
    <div class="clear"></div>

    <div class="item">
      <div class="left">
        <?php echo $form['summary']->renderLabel() ?>
        <div id="summary_length"><span>0</span> / 275</div>
      </div>
      <div class="right">
        <?php echo $form['summary']->renderError() ?>
        <?php echo $form['summary'] ?>
      </div>
      <div class="help rnd_2">
        <?php echo image_tag('news_add_box_arrow.gif') ?>
        A <span>brief description</span> of the product, technology, company, or source. 275 characters max.
      </div>
    </div>
    <div class="clear"></div>

    <?php echo image_tag('image_chooser_left.gif', array('class' => 'image_chooser_left')) ?>
    <?php echo image_tag('image_chooser_right.gif', array('class' => 'image_chooser_right')) ?>
    <span class="image_chooser_text">scan through and select the best image</span>
    <div class="image_suggestions"></div>

    <?php echo $form['_csrf_token'] ?>
    <div class="clear"></div>

    <h2 class="stub rnd_3">
      Suggesting this limelight will create a limelight 'stub.' 
      Any registered user (regardless of account score), can edit most parts of a stub. Once a stub
      has been sufficiently filled out, it will become an active limelight.
    </h2>

    <div class="submit rnd_3" data-url="<?php echo url_for('lime_suggest_process') ?>">suggest limelight</div>
    <div class="clear"></div>
  </div>
  <?php endif ?>
</div>

<?php include_partial('content/layoutPart2'); ?>