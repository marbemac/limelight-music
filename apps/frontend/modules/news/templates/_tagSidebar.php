<h2 class="sidebar_tip" title="Tags help <?php echo sfConfig::get('app_site_name') ?> understand what content means. Please add and rate tags to help users find content more easily!">story tags</h2>
<div class="sidebar_C side_tags rnd_2">
  <?php if ($tag_lock == 0 || $sf_user->hasPermission('function_lock')): ?>
  <div id="tags_add" class="<?php echo !$sf_user->isAuthenticated() ? 'authenticate' : 'blind_new' ?> rnd_3" data-target="#newsTagF" data-text="hide form">add tags</div>
  
  <div class="clearLeft"></div>

  <form id="newsTagF" action="<?php echo url_for('news_tag_add', array('news_id' => $item_id)) ?>">
    <?php echo $tagForm['name']->renderLabel() ?>
    <div class="clear"></div>
    <?php echo $tagForm['name']->render() ?>
    <?php echo $tagForm['_csrf_token'] ?>
    <input class="submit rnd_3" type="submit" value="add" />
  </form>

  <div class="clear"></div>
  <?php endif; ?>

  <ul class="tag_list">
    <?php if (count($tags) > 0): ?>
      <?php foreach ($tags as $key => $tag): ?>
        <?php if (count($tags) > sfConfig::get('app_tag_sidebar_max') && $key == sfConfig::get('app_tag_sidebar_max')): ?>
          <div id="tag_more_list" class="hide">
        <?php endif ?>
            <li>
            <?php
            include_partial('tag', array(
              'id'       => $tag['NewsTags'][0]['id'],
              'user_id'  => $tag['NewsTags'][0]['user_id'],
              'name'     => $tag['name'],
              'score'    => $tag['NewsTags'][0]['score'],
              'pos'      => 'left'
            ));
            ?>
            </li>
      <?php endforeach ?>
      <?php if (count($tags) > sfConfig::get('app_tag_sidebar_max')): ?>
        </div>
        <li id="tag_more" class="blind rnd_3" blindElem="tag_more_list" blindText="hide extra tags">show <?php echo count($tags) - sfConfig::get('app_tag_sidebar_max') ?> more</li>
      <?php endif ?>
    <?php else: ?>
      <li><i>none</i></li>
    <?php endif ?>
  </ul>
  <div class="clearLeft"></div>
</div>