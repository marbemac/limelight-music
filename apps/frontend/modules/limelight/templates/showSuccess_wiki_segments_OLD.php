<?php
  slot('title', sprintf('%s info', $limelight['name']));
  include_component('limelight', 'limelightHead', array('limelight' => $limelight, 'page' => 'info', 'sf_cache_key' => $limelight['id']));
?>

<div class="clearLeft"></div>
<div class="content_panel">
  <?php
//    if ($limelight['wiki_lock'] == 0)
//      include_partial('lockWiki', array('item' => $limelight, 'lock_code' => 1, 'lock_text' => 'lock wiki'));
//    else
//      include_partial('lockWiki', array('item' => $limelight, 'lock_code' => 0, 'lock_text' => 'unlock wiki'));
//
//    if ($limelight['spec_lock'] == 0)
//      include_partial('lockSpecs', array('item' => $limelight, 'lock_code' => 1, 'lock_text' => 'lock specifications'));
//    else
//      include_partial('lockSpecs', array('item' => $limelight, 'lock_code' => 0, 'lock_text' => 'unlock specifications'));
//
//    if ($limelight['procon_lock'] == 0)
//      include_partial('lockProcon', array('item' => $limelight, 'lock_code' => 1, 'lock_text' => 'lock pros/cons'));
//    else
//      include_partial('lockProcon', array('item' => $limelight, 'lock_code' => 0, 'lock_text' => 'unlock pros/cons'));
//
//    include_component('limelight', 'proscons', array('limelight' => $limelight, 'user_id' => $user_id, 'sf_cache_key' => 'll_id='.$limelight->id.'&user_id='.$user_id));
//    include_component('limelight', 'wiki', array('limelight' => $limelight, 'sf_cache_key' => 'll_id='.$limelight->id.'&user_id='.$user_id));
  ?>

  <?php  include_component('limelight', 'limelightCategories', array('limelight' => $limelight, 'show_add' => true)) ?>

  <div class="limelight_info_section specifications">
    <h2 class="rnd_3">specifications <span class="new_spec blind_new rnd_3" title="add a new specification for the <?php echo $limelight['name'] ?>" data-target="#specification_F" data-text="hide form">add specification</span></h2>

    <form id="specification_F" class="rnd_3" action="<?php echo url_for('lime_specification_add') ?>">
      <h5>add specification</h5>
      <div class="item">
        <?php echo $specificationForm['name']->renderLabel() ?>
        <?php echo $specificationForm['name']->render(array('data-searchahead' => url_for('populate_lime_specifications_ac'), 'data-searchloaded' => '0')) ?>
      </div>
      <div class="item">
        <?php echo $specificationForm['content']->renderLabel() ?>
        <?php echo $specificationForm['content']->render(array('data-searchahead' => url_for('populate_specifications_ac'), 'data-searchloaded' => '0')) ?>
      </div>
      <div class="clear"></div>
      <div class="item">
        <?php echo $specificationForm['source_name']->renderLabel() ?>
        <?php echo $specificationForm['source_name']->render() ?>
      </div>
      <div class="item">
        <?php echo $specificationForm['source_url']->renderLabel() ?>
        <?php echo $specificationForm['source_url']->render() ?>
      </div>
      <input type="hidden" value="<?php echo $limelight['id'] ?>" id="specification_limelight_id" name="specification[limelight_id]">
      <?php echo $specificationForm['_csrf_token'] ?>
      <input type="submit" value="add specification" class="submit" />
    </form>

    <div class="clear"></div>
    <?php if (count($specifications) == 0): ?>
    <div class="none">there are no specifications for the <?php echo $limelight['name'] ?> yet - try adding one by clicking on the 'add a specification' link above</div>
    <?php else: ?>
    <div class="spec_box">
      <ul class="specs">
        <?php foreach ($specifications as $key => $specification): ?>
          <?php if (count($specifications) > sfConfig::get('app_specification_max') && $key == sfConfig::get('app_specification_max')): ?>
            <div id="spec_more_list" class="hide">
          <?php endif ?>
          <li>
            <span class="name rnd_3"><span class="expand rnd_3">+</span><?php echo $specification['name'] ?></span>
            <span class="content"><?php echo $specification['content'] ?></span>
            <div class="clear"></div>
            <span class="extra hide">
            <span class="name">Source:</span>
            <span class="content"><a href="<?php echo $specification['source_url'] ?>" rel="nofollow"><?php echo $specification['Source']['source_name'] ?></a></span>
            <div class="clear"></div>
            <div class="bottom">
              <span class="actions">
                <?php
                include_partial('content/scoreBox', array(
                    'class' => 'lime_spec_'.$specification['id'],
                    'score' => $specification['score'],
                    'type' => 'sb_t',
                    'target' => '.lime_spec_'.$specification['id'],
                    'title' => 'rate this specification',
                    'my' => 'top left',
                    'at' => 'bottom center',
                    'url' => url_for('lime_specification_rate_box', array('id' => $specification['id']))
                  )
                );
                include_partial('content/flagButton', array(
                    'class' => 'limelight_specification_'.$specification['id'],
                    'type' => 'fb_t',
                    'target' => '.limelight_specification_'.$specification['id'],
                    'title' => 'flag this specification',
                    'my' => 'top left',
                    'at' => 'bottom center',
                    'text' => '!',
                    'url' => url_for('lime_specification_flag_box', array('id' => $specification['id']))
                  )
                );
                ?>
              </span>
              <div class="user">
                <?php
                include_component('user', 'userLink', array(
                  'user_id'        => $specification['user_id'],
                  'show_score'     => true,
                  'pos'            => 'top',
                ));
                ?>
                added - <?php echo date('M j, y', strtotime($specification['created_at'])) ?>
              </div>
            </div>
            <div class="clear"></div>
            </span>
          </li>
        <?php endforeach ?>
        <?php if (count($specifications) > sfConfig::get('app_tag_sidebar_max')): ?>
          </div>
          <li class="spec_more blind_new rnd_3" data-target="#spec_more_list" data-text="hide extra specs">show <?php echo count($specifications) - sfConfig::get('app_specifications_max') ?> more</li>
        <?php endif ?>
      </ul>
    </div>
    <div class="clear"></div>
    <?php endif ?>
  </div>

  <div class="limelight_info_section procon">
    <h2 class="rnd_3">
      pros & cons
      <span class="new_pro blind_new rnd_3" title="add a new pro for the <?php echo $limelight['name'] ?>" data-target="#pro_F" data-text="hide pro form">add a pro</span>
      <span class="new_con blind_new rnd_3" title="add a new con for the <?php echo $limelight['name'] ?>" data-target="#con_F" data-text="hide con form">add a con</span>
    </h2>

    <?php include_component('limelight', 'pros', array('limelight' => $limelight)) ?>
    <?php include_component('limelight', 'cons', array('limelight' => $limelight)) ?>
    
    <div class="clear"></div>
  </div>

  <div class="clear"></div>

  <div class="limelight_info_section wikis">
    <h2 class="rnd_3">wiki <span class="new_segment rnd_3" data-url="<?php echo url_for('wiki_new_segment', array('ll_id' => $limelight['id'])) ?>" title="write a new segment for the <?php echo $limelight['name'] ?> wiki">create new segment</span><span class="link_segment rnd_3" title="link and share an existing segment with the <?php echo $limelight['name'] ?> wiki">link a segment</span></h2>
    <div class="desc">Limelight wikis are divided into segments.  Segments maybe be written for a particular limelight, or shared between multiple limelights.</div>

    <div class="link_segment_C rnd_3 hide">
      <h5>link segments</h5>
      <ul class="segment_list"></ul>
      <div class="clear"></div>
      <input type="text" class="input_clear rnd_3" value="enter one or more keywords related to the subject you are searching for" />
      <div class="submit rnd_3" data-url="<?php echo url_for('wiki_find_segments') ?>" data-id="<?php echo $limelight['id'] ?>">search</div>
      <div class="clear"></div>
    </div>

    <form id="new_segment_F" class="rnd_3 hide" action="<?php echo url_for('wiki_new_segment', array('ll_id' => $limelight['id'])) ?>" method="post">
      <h5>new segment</h5>
      <div class="segment_guidelines">wiki <span class="blue">segments</span> represent <span class="red">major</span>, <span class="red">discrete</span> ideas including <span class="orange">companies</span>, <span class="green">products</span>, and <span class="purple">technologies</span></div>
      <?php if ($wikiForm->hasGlobalErrors()): ?>
        <?php foreach ($wikiForm->getGlobalErrors() as $error): ?>
          <div class="error"><?php echo $error ?></div>
        <?php endforeach; ?>
      <?php endif; ?>
      <div class="old_segments hide rnd_3">
        <h4>Does the topic you want to write about match any of the segments below? If so, edit them - don't create a new segment! Mouse-over a segment name for a preview.</h4>
        <ul class="segment_list"></ul>
        <div class="clear"></div>
      </div>
      <label>name</label>
      <?php echo $wikiForm['topics']->render(array('class' => 'input_clear name rnd_3', 'value' => 'please input a name for this wiki segment, (eg \'Apple\', \'iPhone\', \'iPhone 3G\', \'LCD\'...)', 'data-cleared' => '0', 'data-url' => url_for('wiki_find_segments'), 'data-ll_id' => $limelight['id'])); ?>
      <?php echo $wikiForm['content']->render(array('class' => 'rnd_3')); ?>
      <input type="submit" class="submit rnd_3" value="save segment" />
      <div class="cancel rnd_3">cancel</div>
      <div class="clear"></div>
      <?php echo $wikiForm['_csrf_token'] ?>
    </form>

    <?php if (count($wikis) == 0): ?>
    <div class="none">there are currently no wiki segments linked to the <?php echo $limelight['name'] ?> wiki - create a new one or link an existing one by clicking on the buttons above</div>
    <?php else: ?>
    <h4 class="segments rnd_2">segments</h4>
    <ul class="segment_list <?php echo $sf_user->hasPermission('wiki_sort') ? 'sort' : '' ?>" data-url="<?php echo url_for('wiki_resort') ?>">
      <?php foreach ($wikis as $key => $wiki): ?>
      <li class="rnd_3" data-id="<?php echo $wiki['id'] ?>"><span class="key rnd_3"><?php echo $key+1 ?></span> <a href="#wiki_<?php echo $wiki['Wiki']['id'] ?>"><?php echo $wiki['Wiki']['topics'] ?></a></li>
      <?php endforeach ?>
    </ul>
    <?php
    foreach ($wikis as $wiki)
      include_partial('wiki/wikiSegment', array('wiki' => $wiki['Wiki']));
    ?>
    <?php endif ?>
  </div>
</div>