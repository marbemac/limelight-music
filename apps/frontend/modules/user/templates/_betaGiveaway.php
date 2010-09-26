<div id="giveaway_card" class="hide">
  <div id="giveaway_content">
    <h2>Tech Limelight beta giveaway</h2>
    <div class="title">predict the trending product!</div>
    <div class="description">
      Predict which product most people are inputting and get a chance to win a new <?php echo sfConfig::get('app_beta_giveaway_product') ?>!
    </div>
    <div class="status rnd_3">currently if you guess the correct product you have a <span><?php echo LimelightUtils::getGiveawayChance() ?>%</span> chance to win!</div>
    <div class="input code">
      <span>code (found on our Twitter and Facebook pages)</span>
      <input type="text" />
    </div>
    <div class="input product">
      <span>which <?php echo sfConfig::get('app_beta_giveaway_guess') ?> are most people talking about?</span>
      <input type="text" />
    </div>
    <div class="input email">
      <span>email (so we can let you know if you win!)</span>
      <input type="text" />
    </div>
    <div class="error"></div>
    <div id="giveaway_submit" class="submit rnd_3" data-url="<?php echo url_for('user_beta_giveaway') ?>">submit entry</div>
    <a href="http://www.twitter.com/techlimelight"><img src="http://twitter-badges.s3.amazonaws.com/follow_me-b.png" alt="Follow techlimelight on Twitter"/></a>
    <iframe src="http://www.facebook.com/plugins/likebox.php?id=128840593825022&amp;width=300&amp;connections=0&amp;stream=false&amp;header=false&amp;height=62" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:62px;" allowTransparency="true"></iframe>
  </div>
</div>
