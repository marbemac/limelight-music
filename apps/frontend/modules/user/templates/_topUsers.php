<h2>top users</h2>
<div class="sidebar_C top_list rnd_3">
  <ul>
    <li class="rndB_3 on" alt="#users-1">today</li>
    <li class="rndB_3" alt="#users-7">week</li>
    <li class="rndB_3" alt="#users-30">month</li>
    <li class="rndB_3" alt="#users-0">all time</li>
  </ul>

  <div id="users-1" class="list on">
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
  <div id="users-7" class="list hide">
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
  <div id="users-30" class="list hide">
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
  <div id="users-0" class="list hide">
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