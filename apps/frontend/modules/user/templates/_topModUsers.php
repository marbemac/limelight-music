<h2>moderators</h2>
<div class="sidebar_C top_list rnd_3">
  <ul>
    <li class="rndB_3 on" alt="#musers-1">today</li>
    <li class="rndB_3" alt="#musers-7">week</li>
    <li class="rndB_3" alt="#musers-30">month</li>
    <li class="rndB_3" alt="#musers-0">all time</li>
  </ul>

  <div id="musers-1" class="list on">
    <?php
    foreach ($users1 as $key => $user) {
      include_component('user', 'userLink', array(
        'user_id'        => $user['id'],
        'show_score'     => true,
        'pos'            => 'left',
        'count'          => $key+1,
        'score_increase' => isset($user['score_increase']) ? $user['score_increase'] : 0
      ));
    }
    ?>
  </div>
  <div id="musers-7" class="list hide">
    <?php
    foreach ($users7 as $key => $user) {
      include_component('user', 'userLink', array(
        'user_id'        => $user['id'],
        'show_score'     => true,
        'pos'            => 'left',
        'count'          => $key+1,
        'score_increase' => isset($user['score_increase']) ? $user['score_increase'] : 0
      ));
    }
    ?>
  </div>
  <div id="musers-30" class="list hide">
    <?php
    foreach ($users30 as $key => $user) {
      include_component('user', 'userLink', array(
        'user_id'        => $user['id'],
        'show_score'     => true,
        'pos'            => 'left',
        'count'          => $key+1,
        'score_increase' => isset($user['score_increase']) ? $user['score_increase'] : 0
      ));
    }
    ?>
  </div>
  <div id="musers-0" class="list hide">
    <?php
    foreach ($users0 as $key => $user) {
      include_component('user', 'userLink', array(
        'user_id'        => $user['id'],
        'show_score'     => true,
        'pos'            => 'left',
        'count'          => $key+1,
        'score_increase' => isset($user['score_increase']) ? $user['score_increase'] : 0
      ));
    }
    ?>
  </div>
</div>