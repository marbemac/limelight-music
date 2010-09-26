<?php
  slot('title', $user->username.' stats and revenue');
  slot('sidebar0');
    include_component('user', 'profileCard', array('user' => $user));
  end_slot();

  $me = ($sf_user->isAuthenticated() && $sf_user->getGuardUser()->id == $user->id) ? true : false;
?>

<?php include_component('user', 'notifications', array('user' => $user)) ?>
<?php include_partial('user/profileNav', array('user' => $user, 'page' => 'stat_revenue')) ?>
<div class="content_panel">

  <?php if ($me): ?>
  <div class="user_revenue">
    <h1>Revenue</h1>
    <div class="clear"></div>
    <div class="revenue_box">
      <div class="popularity rnd_3">
        <span>popularity since last distribution</span>
        <?php echo $revenue['revenue']['popularity'] ?>
      </div>
      <div class="points rnd_3">
        <span>unclaimed cash balance</span>
        $<?php echo $revenue['revenue']['unclaimed'] ?>
      </div>
      <div class="redeem rnd_3"><?php echo link_to('redeem', 'user_redeem') ?></div>
    </div>
    <p class="description rnd_3">
      <?php echo sfConfig::get('app_site_name') ?> pays you for contributing popular content. Twice a week, cash* is
      distributed to the accounts of top users. The amount of cash distributed is based on the amount of revenue generated
      by <?php echo sfConfig::get('app_site_name') ?> since the last distribution. Become a top user by increasing your
      popularity score. The popularity score is a combination of changes in your account score,
      your community participation, and our secret sauce.
      <span>* a heads up, eventually we plan to move to a points system with rewards from partners</span>
    </p>
    <div class="clear"></div>

    <ul class="claims">
      <li class="h">
        <div >amount</div>
        <div>popularity</div>
        <div>status</div>
        <div>distributed on</div>
        <div>claimed on</div>
      </li>

      <?php if (count($claims) == 0): ?>
      <li><div>none</div></li>
      <?php endif; ?>

      <?php foreach ($claims as $key => $claim): ?>
      <?php $key++ ?>

      <li data-group="<?php echo floor($key/sfConfig::get('app_user_claimlist_max')) ?>" class="<?php echo 'claims_'.floor($key/sfConfig::get('app_user_claimlist_max')) ?> <?php echo ($key != 1) ? 'hide' : '' ?>">
        <div>$<?php echo $claim['amount'] ?></div>
        <div><?php echo $claim['popularity'] ?></div>
        <div class="<?php echo ($claim['claimed']) ? 'claimed' : 'unclaimed' ?> rnd_3">
          <?php
          if ($claim['amount'] > 0)
            echo ($claim['claimed']) ? 'claimed' : 'unclaimed';
          else
            echo 'N/A';
          ?>
        </div>
        <div><?php echo date('M d, Y', strtotime($claim['created_at'])) ?></div>
        <div><?php echo $claim['claim_date'] ? date('M d, Y', strtotime($claim['claim_date'])) : 'N/A' ?></div>
      </li>
      <?php endforeach ?>
    </ul>
    
    <div class="clear"></div>
    <?php if (count($claims) > 1): ?>
    <div class="claims_show_more">show more claim history</div>
    <?php endif ?>
  </div>
  <?php endif ?>
  

  <div class="user_stats">
    <h1>Statistics</h1>
    <div class="clear"></div>

    <div class="choose_period" data-url="<?php echo url_for('user_stat_revenue', array('username' => $user->username)) ?>">
      <span class="stats_t"><?php echo $me ? 'your' : $user->username.'\'s' ?> stats over the past:</span>
      <span class="stats_period on rnd_3" data-value="1">day</span>
      <span class="stats_period rnd_3" data-value="3">3 days</span>
      <span class="stats_period rnd_3" data-value="7">week</span>
      <span class="stats_period rnd_3" data-value="30">month</span>
      <span class="stats_period rnd_3" data-value="0">all time</span>
    </div>

    <h2><span>></span>Overall.</h2>
    <ul class="overall_stats">

      <li title="amount <?php echo $me ? 'your' : $user->username.'\'s' ?> total score has changed">
        <span>score change</span>
        <div id="overall_stats_up" class="up rnd_3"><?php echo $stats['overall_stats']['up']; ?></div>
        <div id="overall_stats_overall" class="<?php echo $stats['overall_stats']['overall'] > 0 ? 'pos' : '' ?> <?php echo $stats['overall_stats']['overall'] < 0 ? 'neg' : '' ?> rnd_3">
          <?php echo $stats['overall_stats']['overall']; ?>
        </div>
        <div id="overall_stats_down" class="down rnd_3"><?php echo $stats['overall_stats']['down']; ?></div>
      </li>

      <li class="<?php echo $stats['overall_rated_stats']['pos'] > 0 ? 'pos' : '' ?> rnd_3" title="# of items <?php echo $me ? 'you' : $user->username ?> rated up and down">
        <span>items rated</span>
        <div id="overall_rated_stats_up" class="up rnd_3"><?php echo $stats['overall_rated_stats']['up']; ?></div>
        <div id="overall_rated_stats_overall" class="<?php echo $stats['overall_rated_stats']['overall'] > 0 ? 'pos' : '' ?> <?php echo $stats['overall_rated_stats']['overall'] < 0 ? 'neg' : '' ?> rnd_3">
          <?php echo $stats['overall_rated_stats']['overall']; ?>
        </div>
        <div id="overall_rated_stats_down" class="down rnd_3"><?php echo $stats['overall_rated_stats']['down']; ?></div>
      </li>

      <li class="rnd_3" title="# of followers <?php echo $me ? 'you have' : $user->username.' has' ?> gained">
        <span>follower change</span>
        <div id="follower_stat_overall" class="<?php echo ($stats['follower_stat']['overall'] > 0) ? 'pos' : '' ?> <?php echo ($stats['follower_stat']['overall'] < 0) ? 'neg' : '' ?> rnd_3">
          <?php echo $stats['follower_stat']['overall'] ?>
        </div>
      </li>
    </ul>
    <div class="clear"></div>

    <h2><span>></span>What types of items <?php echo $me ? 'am I' : 'is '.$user->username ?> contributing?</h2>
    <ul class="rated_stats">
      <li>
        <span>news stories</span>
        <div id="contributed_stats_News" class="<?php echo $stats['contributed_stats']['News'] > 0 ? 'pos' : '' ?> rnd_3">
          <?php echo $stats['contributed_stats']['News']; ?>
        </div>
      </li>

      <li>
        <span>comments</span>
        <div id="contributed_stats_Comment" class="<?php echo $stats['contributed_stats']['Comment'] > 0 ? 'pos' : '' ?> rnd_3">
          <?php echo $stats['contributed_stats']['Comment']; ?>
        </div>
      </li>

      <li>
        <span>news tags</span>
        <div id="contributed_stats_NewsTag" class="<?php echo $stats['contributed_stats']['NewsTag'] > 0 ? 'pos' : '' ?> rnd_3">
          <?php echo $stats['contributed_stats']['NewsTag']; ?>
        </div>
      </li>

      <li>
        <span>news links</span>
        <div id="contributed_stats_NewsLink" class="<?php echo $stats['contributed_stats']['NewsLink'] > 0 ? 'pos' : '' ?> rnd_3">
          <?php echo $stats['contributed_stats']['NewsLink']; ?>
        </div>
      </li>

      <li>
        <span>specifications</span>
        <div id="contributed_stats_LimelightSpecification" class="<?php echo $stats['contributed_stats']['LimelightSpecification'] > 0 ? 'pos' : '' ?> rnd_3">
          <?php echo $stats['contributed_stats']['LimelightSpecification']; ?>
        </div>
      </li>

      <li>
        <span>pros & cons</span>
        <div id="contributed_stats_LimelightProCon" class="<?php echo $stats['contributed_stats']['LimelightProCon'] > 0 ? 'pos' : '' ?> rnd_3">
          <?php echo $stats['contributed_stats']['LimelightProCon']; ?>
        </div>
      </li>

      <li>
        <span>wiki revisions</span>
        <div id="contributed_stats_Wiki" class="<?php echo $stats['contributed_stats']['Wiki'] > 0 ? 'pos' : '' ?> rnd_3">
          <?php echo $stats['contributed_stats']['Wiki']; ?>
        </div>
      </li>

      <li>
        <span>limelights</span>
        <div id="contributed_stats_Limelight" class="<?php echo $stats['contributed_stats']['Limelight'] > 0 ? 'pos' : '' ?> rnd_3">
          <?php echo $stats['contributed_stats']['Limelight']; ?>
        </div>
      </li>
    </ul>
    <div class="clear"></div>

    <h2><span>></span>Where are <?php echo $me ? 'my' : $user->username.'\'s' ?> account points coming from?</h2>
    <ul class="individual_stats">
      <li>
        <span>news stories</span>
        <div id="segmented_stats_News_up" class="up rnd_3"><?php echo $stats['segmented_stats']['News']['up']; ?></div>
        <div id="segmented_stats_News_overall" class="<?php echo $stats['segmented_stats']['News']['overall'] > 0 ? 'pos' : '' ?> <?php echo $stats['segmented_stats']['News']['overall'] < 0 ? 'neg' : '' ?> rnd_3">
          <?php echo $stats['segmented_stats']['News']['overall']; ?>
        </div>
        <div id="segmented_stats_News_down" class="down rnd_3"><?php echo $stats['segmented_stats']['News']['down']; ?></div>
      </li>

      <li>
        <span>comments</span>
        <div id="segmented_stats_Comment_up" class="up rnd_3"><?php echo $stats['segmented_stats']['Comment']['up']; ?></div>
        <div id="segmented_stats_Comment_overall" class="<?php echo $stats['segmented_stats']['Comment']['overall'] > 0 ? 'pos' : '' ?> <?php echo $stats['segmented_stats']['Comment']['overall'] < 0 ? 'neg' : '' ?> rnd_3">
          <?php echo $stats['segmented_stats']['Comment']['overall']; ?>
        </div>
        <div id="segmented_stats_Comment_down" class="down rnd_3"><?php echo $stats['segmented_stats']['Comment']['down']; ?></div>
      </li>

      <li>
        <span>news tags</span>
        <div id="segmented_stats_NewsTag_up" class="up rnd_3"><?php echo $stats['segmented_stats']['NewsTag']['up']; ?></div>
        <div id="segmented_stats_NewsTag_overall" class="<?php echo $stats['segmented_stats']['NewsTag']['overall'] > 0 ? 'pos' : '' ?> <?php echo $stats['segmented_stats']['NewsTag']['overall'] < 0 ? 'neg' : '' ?> rnd_3">
          <?php echo $stats['segmented_stats']['NewsTag']['overall']; ?>
        </div>
        <div id="segmented_stats_NewsTag_down" class="down rnd_3"><?php echo $stats['segmented_stats']['NewsTag']['down']; ?></div>
      </li>

      <li>
        <span>news links</span>
        <div id="segmented_stats_NewsLink_up" class="up rnd_3"><?php echo $stats['segmented_stats']['NewsLink']['up']; ?></div>
        <div id="segmented_stats_NewsLink_overall" class="<?php echo $stats['segmented_stats']['NewsLink']['overall'] > 0 ? 'pos' : '' ?> <?php echo $stats['segmented_stats']['NewsLink']['overall'] < 0 ? 'neg' : '' ?> rnd_3">
          <?php echo $stats['segmented_stats']['NewsLink']['overall']; ?>
        </div>
        <div id="segmented_stats_NewsLink_down" class="down rnd_3"><?php echo $stats['segmented_stats']['NewsLink']['overall']; ?></div>
      </li>

      <li>
        <span>specifications</span>
        <div id="segmented_stats_LimelightSpecification_up" class="up rnd_3"><?php echo $stats['segmented_stats']['LimelightSpecification']['up']; ?></div>
        <div id="segmented_stats_LimelightSpecification_overall" class="<?php echo $stats['segmented_stats']['LimelightSpecification']['overall'] > 0 ? 'pos' : '' ?> <?php echo $stats['segmented_stats']['LimelightSpecification']['overall'] < 0 ? 'neg' : '' ?> rnd_3">
          <?php echo $stats['segmented_stats']['LimelightSpecification']['overall']; ?>
        </div>
        <div id="segmented_stats_LimelightSpecification_down" class="down rnd_3"><?php echo $stats['segmented_stats']['LimelightSpecification']['down']; ?></div>
      </li>

      <li>
        <span>pros & cons</span>
        <div id="segmented_stats_LimelightProCon_up" class="up rnd_3"><?php echo $stats['segmented_stats']['LimelightProCon']['up']; ?></div>
        <div id="segmented_stats_LimelightProCon_overall" class="<?php echo $stats['segmented_stats']['LimelightProCon']['overall'] > 0 ? 'pos' : '' ?> <?php echo $stats['segmented_stats']['LimelightProCon']['overall'] < 0 ? 'neg' : '' ?> rnd_3">
          <?php echo $stats['segmented_stats']['LimelightProCon']['overall']; ?>
        </div>
        <div id="segmented_stats_LimelightProCon_down" class="down rnd_3"><?php echo $stats['segmented_stats']['LimelightProCon']['down']; ?></div>
      </li>

      <li>
        <span>wiki revisions</span>
        <div id="segmented_stats_Wiki_up" class="up rnd_3"><?php echo $stats['segmented_stats']['Wiki']['up']; ?></div>
        <div id="segmented_stats_Wiki_overall" class="<?php echo $stats['segmented_stats']['Wiki']['overall'] > 0 ? 'pos' : '' ?> <?php echo $stats['segmented_stats']['Wiki']['overall'] < 0 ? 'neg' : '' ?> rnd_3">
          <?php echo $stats['segmented_stats']['Wiki']['overall']; ?>
        </div>
        <div id="segmented_stats_Wiki_down" class="down rnd_3"><?php echo $stats['segmented_stats']['Wiki']['down']; ?></div>
      </li>

      <li>
        <span>badges</span>
        <div id="segmented_stats_badge_up" class="up rnd_3"><?php echo $stats['segmented_stats']['badge']['up']; ?></div>
        <div id="segmented_stats_badge_overall" class="<?php echo $stats['segmented_stats']['badge']['overall'] > 0 ? 'pos' : '' ?> <?php echo $stats['segmented_stats']['badge']['overall'] < 0 ? 'neg' : '' ?> rnd_3">
          <?php echo $stats['segmented_stats']['badge']['overall']; ?>
        </div>
        <div id="segmented_stats_badge_down" class="down rnd_3"><?php echo $stats['segmented_stats']['badge']['down']; ?></div>
      </li>
    </ul>
    <div class="clear"></div>

    <h2><span>></span>What <?php echo $me ? 'am I' : 'is '.$user->username ?> rating?</h2>
    <ul class="rated_stats">
      <li>
        <span>news stories</span>
        <div id="segmented_rated_stats_News_up" class="up rnd_3"><?php echo $stats['segmented_rated_stats']['News']['up']; ?></div>
        <div id="segmented_rated_stats_News_overall" class="<?php echo $stats['segmented_rated_stats']['News']['overall'] > 0 ? 'pos' : '' ?> <?php echo $stats['segmented_rated_stats']['News']['overall'] < 0 ? 'neg' : '' ?> rnd_3">
          <?php echo $stats['segmented_rated_stats']['News']['overall']; ?>
        </div>
        <div id="segmented_rated_stats_News_down" class="down rnd_3"><?php echo $stats['segmented_rated_stats']['News']['down']; ?></div>
      </li>

      <li>
        <span>comments</span>
        <div id="segmented_rated_stats_Comment_up" class="up rnd_3"><?php echo $stats['segmented_rated_stats']['Comment']['up']; ?></div>
        <div id="segmented_rated_stats_Comment_overall" class="<?php echo $stats['segmented_rated_stats']['Comment']['overall'] > 0 ? 'pos' : '' ?> <?php echo $stats['segmented_rated_stats']['Comment']['overall'] < 0 ? 'neg' : '' ?> rnd_3">
          <?php echo $stats['segmented_rated_stats']['Comment']['overall']; ?>
        </div>
        <div id="segmented_rated_stats_Comment_down" class="down rnd_3"><?php echo $stats['segmented_rated_stats']['Comment']['down']; ?></div>
      </li>

      <li>
        <span>news tags</span>
        <div id="segmented_rated_stats_NewsTag_up" class="up rnd_3"><?php echo $stats['segmented_rated_stats']['NewsTag']['up']; ?></div>
        <div id="segmented_rated_stats_NewsTag_overall" class="<?php echo $stats['segmented_rated_stats']['NewsTag']['overall'] > 0 ? 'pos' : '' ?> <?php echo $stats['segmented_rated_stats']['NewsTag']['overall'] < 0 ? 'neg' : '' ?> rnd_3">
          <?php echo $stats['segmented_rated_stats']['NewsTag']['overall']; ?>
        </div>
        <div id="segmented_rated_stats_NewsTag_down" class="down rnd_3"><?php echo $stats['segmented_rated_stats']['NewsTag']['down']; ?></div>
      </li>

      <li>
        <span>news links</span>
        <div id="segmented_rated_stats_NewsLink_up" class="up rnd_3"><?php echo $stats['segmented_rated_stats']['NewsLink']['up']; ?></div>
        <div id="segmented_rated_stats_NewsLink_overall" class="<?php echo $stats['segmented_rated_stats']['NewsLink']['overall'] > 0 ? 'pos' : '' ?> <?php echo $stats['segmented_rated_stats']['NewsLink']['overall'] < 0 ? 'neg' : '' ?> rnd_3">
          <?php echo $stats['segmented_rated_stats']['NewsLink']['overall']; ?>
        </div>
        <div id="segmented_rated_stats_NewsLink_down" class="down rnd_3"><?php echo $stats['segmented_rated_stats']['NewsLink']['overall']; ?></div>
      </li>

      <li>
        <span>specifications</span>
        <div id="segmented_rated_stats_LimelightSpecification_up" class="up rnd_3"><?php echo $stats['segmented_rated_stats']['LimelightSpecification']['up']; ?></div>
        <div id="segmented_rated_stats_LimelightSpecification_overall" class="<?php echo $stats['segmented_rated_stats']['LimelightSpecification']['overall'] > 0 ? 'pos' : '' ?> <?php echo $stats['segmented_rated_stats']['LimelightSpecification']['overall'] < 0 ? 'neg' : '' ?> rnd_3">
          <?php echo $stats['segmented_rated_stats']['LimelightSpecification']['overall']; ?>
        </div>
        <div id="segmented_rated_stats_LimelightSpecification_down" class="down rnd_3"><?php echo $stats['segmented_rated_stats']['LimelightSpecification']['down']; ?></div>
      </li>

      <li>
        <span>pros & cons</span>
        <div id="segmented_rated_stats_LimelightProCon_up" class="up rnd_3"><?php echo $stats['segmented_rated_stats']['LimelightProCon']['up']; ?></div>
        <div id="segmented_rated_stats_LimelightProCon_overall" class="<?php echo $stats['segmented_rated_stats']['LimelightProCon']['overall'] > 0 ? 'pos' : '' ?> <?php echo $stats['segmented_rated_stats']['LimelightProCon']['overall'] < 0 ? 'neg' : '' ?> rnd_3">
          <?php echo $stats['segmented_rated_stats']['LimelightProCon']['overall']; ?>
        </div>
        <div id="segmented_rated_stats_LimelightProCon_down" class="down rnd_3"><?php echo $stats['segmented_rated_stats']['LimelightProCon']['down']; ?></div>
      </li>

      <li>
        <span>wiki revisions</span>
        <div id="segmented_rated_stats_Wiki_up" class="up rnd_3"><?php echo $stats['segmented_rated_stats']['Wiki']['up']; ?></div>
        <div id="segmented_rated_stats_Wiki_overall" class="<?php echo $stats['segmented_rated_stats']['Wiki']['overall'] > 0 ? 'pos' : '' ?> <?php echo $stats['segmented_rated_stats']['Wiki']['overall'] < 0 ? 'neg' : '' ?> rnd_3">
          <?php echo $stats['segmented_rated_stats']['Wiki']['overall']; ?>
        </div>
        <div id="segmented_rated_stats_Wiki_down" class="down rnd_3"><?php echo $stats['segmented_rated_stats']['Wiki']['down']; ?></div>
      </li>
    </ul>
    <div class="clear"></div>
  </div>
</div>