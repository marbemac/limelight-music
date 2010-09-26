<div class="limelight_info_section specifications">
  <h2 class="rnd_3"><?php echo $spec_requirements_check ?>s <span class="new_spec blind_new rnd_3" title="add a new specification for the <?php echo $limelight['name'] ?>" data-target="#specification_F" data-text="hide form">add <?php echo $spec_requirements_check ?></span></h2>

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
    <div class="slice">
      <label>Slice</label>
      <?php echo $specificationForm['slices']->render() ?>
    </div>
    <input type="hidden" value="<?php echo $limelight['id'] ?>" id="specification_limelight_id" name="specification[limelight_id]">
    <?php echo $specificationForm['_csrf_token'] ?>
    <input type="submit" value="add specification" class="submit" />
  </form>

  <div class="clear"></div>
  
  <div class="spec_box">
    <?php include_partial('specification', array('specifications' => $specifications, 'spec_requirements_check' => $spec_requirements_check, 'limelight' => $limelight, 'slice' => array('id' => 0, 'name' => ''))) ?>

    <?php foreach ($slices as $slice): ?>
    <?php include_partial('specification', array('specifications' => $specifications, 'spec_requirements_check' => $spec_requirements_check, 'limelight' => $limelight, 'slice' => $slice)) ?>
    <?php endforeach ?>
  </div>
  <div class="clear"></div>
</div>