<?php include_partial('content/layoutPart1'); ?>

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
        <span>songs</span>
        <div id="contributed_stats_Song" class="<?php echo $stats['contributed_stats']['Song'] > 0 ? 'pos' : '' ?> rnd_3">
          <?php echo $stats['contributed_stats']['Song']; ?>
        </div>
      </li>

      <li>
        <span>comments</span>
        <div id="contributed_stats_Comment" class="<?php echo $stats['contributed_stats']['Comment'] > 0 ? 'pos' : '' ?> rnd_3">
          <?php echo $stats['contributed_stats']['Comment']; ?>
        </div>
      </li>

      <li>
        <span>item tags</span>
        <div id="contributed_stats_ItemTag" class="<?php echo $stats['contributed_stats']['ItemTag'] > 0 ? 'pos' : '' ?> rnd_3">
          <?php echo $stats['contributed_stats']['ItemTag']; ?>
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
        <span>songs</span>
        <div id="segmented_stats_Song_up" class="up rnd_3"><?php echo $stats['segmented_stats']['Song']['up']; ?></div>
        <div id="segmented_stats_Song_overall" class="<?php echo $stats['segmented_stats']['Song']['overall'] > 0 ? 'pos' : '' ?> <?php echo $stats['segmented_stats']['Song']['overall'] < 0 ? 'neg' : '' ?> rnd_3">
          <?php echo $stats['segmented_stats']['Song']['overall']; ?>
        </div>
        <div id="segmented_stats_Song_down" class="down rnd_3"><?php echo $stats['segmented_stats']['Song']['down']; ?></div>
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
        <span>item tags</span>
        <div id="segmented_stats_ItemTag_up" class="up rnd_3"><?php echo $stats['segmented_stats']['ItemTag']['up']; ?></div>
        <div id="segmented_stats_ItemTag_overall" class="<?php echo $stats['segmented_stats']['ItemTag']['overall'] > 0 ? 'pos' : '' ?> <?php echo $stats['segmented_stats']['ItemTag']['overall'] < 0 ? 'neg' : '' ?> rnd_3">
          <?php echo $stats['segmented_stats']['ItemTag']['overall']; ?>
        </div>
        <div id="segmented_stats_NewsTag_down" class="down rnd_3"><?php echo $stats['segmented_stats']['ItemTag']['down']; ?></div>
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
        <span>songs</span>
        <div id="segmented_rated_stats_Song_up" class="up rnd_3"><?php echo $stats['segmented_rated_stats']['Song']['up']; ?></div>
        <div id="segmented_rated_stats_Song_overall" class="<?php echo $stats['segmented_rated_stats']['Song']['overall'] > 0 ? 'pos' : '' ?> <?php echo $stats['segmented_rated_stats']['Song']['overall'] < 0 ? 'neg' : '' ?> rnd_3">
          <?php echo $stats['segmented_rated_stats']['Song']['overall']; ?>
        </div>
        <div id="segmented_rated_stats_Song_down" class="down rnd_3"><?php echo $stats['segmented_rated_stats']['Song']['down']; ?></div>
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
        <span>item tags</span>
        <div id="segmented_rated_stats_ItemTag_up" class="up rnd_3"><?php echo $stats['segmented_rated_stats']['ItemTag']['up']; ?></div>
        <div id="segmented_rated_stats_ItemTag_overall" class="<?php echo $stats['segmented_rated_stats']['ItemTag']['overall'] > 0 ? 'pos' : '' ?> <?php echo $stats['segmented_rated_stats']['ItemTag']['overall'] < 0 ? 'neg' : '' ?> rnd_3">
          <?php echo $stats['segmented_rated_stats']['ItemTag']['overall']; ?>
        </div>
        <div id="segmented_rated_stats_ItemTag_down" class="down rnd_3"><?php echo $stats['segmented_rated_stats']['ItemTag']['down']; ?></div>
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

<?php include_partial('content/layoutPart2'); ?>