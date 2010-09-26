<h2>top limelights</h2>
<div class="sidebar_C top_list rnd_3">
  <ul>
    <li class="rndB_3 on" alt="#limelights-1">today</li>
    <li class="rndB_3" alt="#limelights-7">week</li>
    <li class="rndB_3" alt="#limelights-30">month</li>
    <li class="rndB_3" alt="#limelights-0">all time</li>
  </ul>

  <div id="limelights-1" class="list on">
    <?php
    foreach ($limelights1 as $key => $limelight) {
      include_component('limelight', 'limelightLink', array(
        'id'             => $limelight['id'],
        'pic'            => true,
        'score'          => $limelight['score'],
        'score_increase' => isset($limelight['score_increase']) ? $limelight['score_increase'] : 0,
        'my'             => 'bottom right',
        'at'             => 'top center'
      ));
    }
    ?>
  </div>
  <div id="limelights-7" class="list hide">
    <?php
    foreach ($limelights7 as $key => $limelight) {
      include_component('limelight', 'limelightLink', array(
        'id'             => $limelight['id'],
        'pic'            => true,
        'score'          => $limelight['score'],
        'score_increase' => isset($limelight['score_increase']) ? $limelight['score_increase'] : 0,
        'my'             => 'bottom right',
        'at'             => 'top center'
      ));
    }
    ?>
  </div>
  <div id="limelights-30" class="list hide">
    <?php
    foreach ($limelights30 as $key => $limelight) {
      include_component('limelight', 'limelightLink', array(
        'id'             => $limelight['id'],
        'pic'            => true,
        'score'          => $limelight['score'],
        'score_increase' => isset($limelight['score_increase']) ? $limelight['score_increase'] : 0,
        'my'             => 'bottom right',
        'at'             => 'top center'
      ));
    }
    ?>
  </div>
  <div id="limelights-0" class="list hide">
    <?php
    foreach ($limelights0 as $key => $limelight) {
      include_component('limelight', 'limelightLink', array(
        'id'             => $limelight['id'],
        'pic'            => true,
        'score'          => $limelight['score'],
        'score_increase' => isset($limelight['score_increase']) ? $limelight['score_increase'] : 0,
        'my'             => 'bottom right',
        'at'             => 'top center'
      ));
    }
    ?>
  </div>
</div>