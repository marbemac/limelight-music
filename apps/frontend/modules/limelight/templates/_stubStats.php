<div class="stub_C rnd_3">
  <div class="name">this limelight is a stub</div>
  <div class="clear"></div>
  <div class="desc">
    A stub is a limelight that does not have enough content contributed to it yet to become an active limelight.
    The user score requirements for contributing to stubs are much lower than for active limelights.
  </div>
</div>

<?php if ($limelight['limelight_type'] == 'product'): ?>
<div class="stub_health_C rnd_3">
  <div class="overall_H">progress to active</div>
  <div class="overall rnd_2"><div class="score" style="width: <?php echo $stub_stats['Overall'] ?>%"></div><span><?php echo $stub_stats['Overall'] ?>%</span></div>
  <div class="show blind_new rnd_3" data-target="#stub_details" data-text="hide details">show details</div>
  <div class="approve user_action rnd_3" data-url="<?php echo url_for('lime_approve', array('id' => $limelight['id'])) ?>">approve</div>
  <div class="clear"></div>
  <div id="stub_details" class="hide">
    <div class="part"><div class="name <?php echo $stub_stats['News']['status'] ?> rnd_3">news stories</div></div>
    <div class="part"><div class="name <?php echo $stub_stats['Wiki']['status'] ?> rnd_3">wiki</div></div>
    <div class="part"><div class="name <?php echo $stub_stats['LimelightSpecification']['status'] ?> rnd_3">specifications</div></div>
    <div class="part"><div class="name <?php echo $stub_stats['LimelightProCon']['status'] ?> rnd_3">pros & cons</div></div>
  </div>
</div>
<?php endif ?>

<div class="clear"><br /></div>