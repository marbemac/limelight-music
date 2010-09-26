<div class="procon_C pros rnd_3">
  <form id="pro_F" class="hide" action="<?php echo url_for('lime_pro_add') ?>">
    <h5>add pro</h5>
    <div id="pro_LI"><span></span>/<?php echo sfConfig::get('app_limelight_procon_max_length') ?></div>
    <?php echo $form['name']->render(array('data-searchahead' => url_for('populate_lime_pros_ac'), 'lengthIndicator' => '#pro_LI')) ?>
    <div class="slice">
      <label>Slice</label>
      <?php echo $form['slices']->render() ?>
    </div>
    <input type="hidden" value="<?php echo $limelight['id'] ?>" id="pro_limelight_id" name="limelight_procon[limelight_id]">
    <?php echo $form['_csrf_token'] ?>
    <input type="submit" value="submit" class="submit rnd_3" />
  </form>

  <?php include_partial('pro', array('pros' => $pros, 'limelight' => $limelight, 'slice' => array('id' => 0, 'name' => ''))) ?>
  <?php foreach ($slices as $slice): ?>
  <?php include_partial('pro', array('pros' => $pros, 'limelight' => $limelight, 'slice' => $slice)) ?>
  <?php endforeach ?>
</div>