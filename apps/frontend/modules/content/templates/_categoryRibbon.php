<?php
$filters = $sf_user->getAttribute('filters');
$selected_cats = json_decode($filters['categories']);
$actionName = sfContext::getInstance()->getActionName();
if (sfContext::getInstance()->getModuleName() != 'news' && sfContext::getInstance()->getModuleName() != 'limelight')
  $moduleName = strtolower($filters['feed_type']);
else
  $moduleName = sfContext::getInstance()->getModuleName();
?>

<div id="feed_reload" class="" data-reload="0" data-url="<?php echo url_for('homepage') ?>"></div>
<div class="categories">
  <a href="<?php echo url_for('feed_'.$moduleName.'_category', array('category' => 'all')) ?>" class="cat_all xa rnd_3 <?php echo ($selected_cats[0] == 0 && $actionName == 'feed') ? 'on' : '' ?>">
    <div class="arrow"></div>
    all categories
  </a>
  <ul class="categories_filter">
    <?php foreach ($categories as $key => $category): ?>
    <?php if ($category['parent_id'] == null): ?>
    <li class="top <?php echo ($actionName == 'feed' && in_array($category['id'], $selected_cats)) ? 'on' : '' ?>" data-value="<?php echo $category['id'] ?>">
      <a href="<?php echo url_for('feed_'.$moduleName.'_category', array('category' => $category['name_slug'])) ?>" class="name top xa rnd_3">
        <div class="arrow"></div>
        <?php echo $category['name'] ?>
      </a>

      <?php if (count($category['Children']) > 0): ?>
      <div class="expander top rndT_3"></div>
      <ul class="child1 rnd_3 hide">
        <?php foreach ($category['Children'] as $child1): ?>
        <li class="<?php echo ($actionName == 'feed' && in_array($child1['id'], $selected_cats)) ? 'on' : '' ?>" data-value="<?php echo $child1['id'] ?>">
          <a href="<?php echo url_for('feed_'.$moduleName.'_category', array('category' => $child1['name_slug'])) ?>" class="name xa rnd_3"><?php echo $child1['name'] ?></a>

          <?php if (count($child1['Children']) > 0): ?>
          <div class="expander rndL_3">></div>
          <ul class="child2 rnd_3 hide">
            <?php foreach ($child1['Children'] as $child2): ?>
            <li class="<?php echo ($actionName == 'feed' && in_array($child2['id'], $selected_cats)) ? 'on' : '' ?>" data-value="<?php echo $child2['id'] ?>">
              <a href="<?php echo url_for('feed_'.$moduleName.'_category', array('category' => $child2['name_slug'])) ?>" class="name xa rnd_3"><?php echo $child2['name'] ?></a>
            </li>
            <?php endforeach ?>
          </ul>
          <?php endif ?>
          <?php endforeach ?>
        </li>
        <div class="clear"></div>
      </ul>
      <?php endif ?>
    </li>

    <?php endif ?>
    <?php endforeach ?>
    <div class="clear"></div>
  </ul>
</div>
<div class="clear"></div>