<h2 class="sidebar_tip" title="This is a list of the scores required to perform certain actions on limelight. Earn reputation points to open up new features!">user actions</h2>
<div class="sidebar_C rnd_3">
  <ul class="user_mod_levels">
    <li>
      <span class="score">score</span>
      <span class="actions">action</span>
    </li>
    <?php $levels = LimelightUtils::getUserActionLevels() ?>
    <?php for ($i=0; $i < count($levels); $i++): ?>
      <?php
      if ($user->Profile->score >= $levels[$i]['min_score'])
        $active = 'active';
      else
        $active = '';
      ?>
      <li>
        <div class="rnd_3 <?php echo $active ?>"><?php echo $levels[$i]['min_score'] ?></div>
        <ul class="rnd_3 <?php echo $active ?>">
          <?php for ($k=0; $k < count($levels[$i]['names']); $k++): ?>
            <li><?php echo $levels[$i]['names'][$k] ?></li>
          <?php endfor ?>
        </ul>
      </li>
    <?php endfor ?>
  </ul>
  <div class="clear"></div>
</div>