<div class="slices">
  <div class="add blind_new" data-target="#slice_F" data-text="cancel add">add slice</div>
  <div class="slice on rnd_3" data-id="0">General <?php echo $limelight['name'] ?></div>

  <?php foreach ($slices as $slice): ?>
  <div class="slice rnd_3" data-id="<?php echo $slice['id'] ?>"><?php echo $limelight['name'] . ' ' .$slice['name'] ?></div>
  <?php endforeach ?>
</div>
<div class="clear"></div>

<form id="slice_F" class="hide rnd_3" action="<?php echo url_for('lime_slice_add') ?>">
  <div class="item">
    <?php echo $sliceForm['name']->renderLabel() ?>
    <?php echo $sliceForm['name']->render() ?>
  </div>
  <input type="hidden" value="<?php echo $limelight['id'] ?>" id="slice_limelight_id" name="slice[limelight_id]">
  <?php echo $sliceForm['_csrf_token'] ?>
  <input type="submit" value="create it" class="submit" />
</form>