<?php include_partial('content/layoutPart1'); ?>

<?php
  slot('title', sprintf('%s info', $limelight['name']));
  include_component('limelight', sfConfig::get('app_site_type').'LimelightHead', array('limelight' => $limelight, 'page' => 'info', 'sf_cache_key' => $limelight['id']));

  if ($limelight['is_stub'])
  {
    slot('sidebar0');
      include_component('limelight', 'stubStats', array('limelight' => $limelight));
    end_slot();
  }
?>

<div class="content_panel">

  <?php
  if ($limelight['limelight_type'] == 'product')
    include_component('limelight', 'slices', array('slices' => $slices, 'limelight' => $limelight))
  ?>

  <?php
  if ($limelight['limelight_type'] == 'product')
    include_component('limelight', 'specifications', array('limelight' => $limelight, 'slices' => $slices, 'spec_requirements_check' => $spec_requirements_check))
  ?>

  <?php if ($limelight['limelight_type'] == 'company'): ?>
  <div class="limelight_info_section products">
    <h2 class="rnd_3">
      <?php echo $limelight['name'] ?> products
      <span class="new_product rnd_3" title="add a new <?php echo $limelight['name'] ?> product" data-target="#pro_F" data-text="hide pro form">add a product</span>
    </h2>
    <div class="product_list">
    <?php
    if (count($products) > 0)
    {
      foreach ($products as $key => $product)
      {
        include_component('limelight', 'limelightLink', array(
          'id'             => $product['id'],
          'pic'            => true,
          'score'          => $product['score'],
          'my'             => 'bottom right',
          'at'             => 'top center'
        ));
      }
    }
    else
    {
      echo '<div class="none">no '.$limelight['name'].' products have been added as limelights yet</div>';
    }
    ?>
    </div>
    <div class="clear"></div>
  </div>
  <?php endif ?>
  
  <?php if ($limelight['limelight_type'] == 'product' || $limelight['limelight_type'] == 'technology'): ?>
  <div class="limelight_info_section procon <?php echo $limelight['limelight_type'] == 'product' ? 'spec_adjust' : '' ?>">
    <h2 class="rnd_3">
      pros & cons (features)
      <span class="new_pro blind_new rnd_3" title="add a new pro for the <?php echo $limelight['name'] ?>" data-target="#pro_F" data-text="hide pro form">add a pro</span>
      <span class="new_con blind_new rnd_3" title="add a new con for the <?php echo $limelight['name'] ?>" data-target="#con_F" data-text="hide con form">add a con</span>
    </h2>

    <?php include_component('limelight', 'pros', array('limelight' => $limelight, 'slices' => $slices)) ?>
    <?php include_component('limelight', 'cons', array('limelight' => $limelight, 'slices' => $slices)) ?>
    
    <div class="clear"></div>
  </div>
  <?php endif ?>

  <div class="limelight_info_section wikis">
  <?php
  foreach ($wikis as $wiki)
    include_partial('wiki/wikiSegment', array('wiki' => $wiki['Wiki']));
  ?>
  </div>
</div>

<?php include_partial('content/layoutPart2'); ?>