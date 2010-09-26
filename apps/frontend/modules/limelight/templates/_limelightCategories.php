<div class="limelight_cat_C rnd_3">
  <?php if (count($categories['Categories']) == 0): ?>
  <span class="none">there are no categories associated with the <?php echo $limelight['name'] ?> limelight</span>
  <?php else: ?>
    <ul class="category_crumbs">
    <?php $parent_flag = false ?>
    <?php foreach ($categories['Categories'] as $key1 => $cat1): ?>

      <?php if ($cat1['parent_id'] == null): ?>
      <?php echo $parent_flag ? '<span class="and"> &&</span>' : '' ?>
      <li class="one rnd_3">
        <?php echo $cat1['name'] ?>
      </li>

        <?php $child1_flag = false ?>
        <?php foreach ($categories['Categories'] as $key2 => $cat2): ?>
          <?php if ($cat2['parent_id'] == $cat1['id']): ?>

          <?php if (!$child1_flag): ?>
          <?php $child1_flag = true ?>
          <span class="next">>></span>
          <?php else: ?>
          <span class="and"> &&</span>
          <?php endif ?>

          <li class="two rnd_3"><?php echo $cat2['name'] ?></li>
            <?php $child2_flag = false ?>
            <?php foreach ($categories['Categories'] as $key3 => $cat3): ?>
              <?php if ($cat3['parent_id'] == $cat2['id']): ?>
                <?php if (!$child2_flag): ?>
                <?php $child2_flag = true ?>
                <span class="next">>></span>
                <?php else: ?>
                <span class="and"> &</span>
                <?php endif ?>
                <li class="three rnd_3">
                  <?php echo $cat3['name'] ?>
                </li>
              <?php endif ?>
            <?php endforeach ?>

          <?php endif ?>
        <?php endforeach ?>
        <?php $parent_flag = true; ?>
      <?php endif ?>

    <?php endforeach ?>
    </ul>
  <?php endif ?>
  
  <?php if (isset($show_add)): ?>
  <div class="attach rnd_3">add category</div>
  <?php endif ?>

  <div class="clear"></div>
</div>