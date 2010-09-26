<div class="procon_C cons rnd_3">
  <form id="con_F" class="hide" action="<?php echo url_for('lime_con_add') ?>">
    <h5>add con</h5>
    <div id="con_LI"><span></span>/<?php echo sfConfig::get('app_limelight_procon_max_length') ?></div>
    <?php echo $form['name']->render(array('data-searchahead' => url_for('populate_lime_cons_ac'), 'lengthIndicator' => '#con_LI')) ?>
    <div class="slice">
      <label>Slice</label>
      <?php echo $form['slices']->render() ?>
    </div>
    <input type="hidden" value="<?php echo $limelight['id'] ?>" id="con_limelight_id" name="limelight_procon[limelight_id]">
    <?php echo $form['_csrf_token'] ?>
    <input type="submit" value="submit" class="submit rnd_3" />
  </form>

  <?php include_partial('con', array('cons' => $cons, 'limelight' => $limelight, 'slice' => array('id' => 0, 'name' => ''))) ?>
  <?php foreach ($slices as $slice): ?>
  <?php include_partial('con', array('cons' => $cons, 'limelight' => $limelight, 'slice' => $slice)) ?>
  <?php endforeach ?>

</div>