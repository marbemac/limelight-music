<?php
  slot('title', $user->username.' settings');
  slot('sidebar0');
    include_component('user', 'profileCard', array('user' => $user));
  end_slot();
?>

<?php include_component('user', 'notifications', array('user' => $user)) ?>
<?php include_partial('user/profileNav', array('user' => $user, 'page' => 'settings')) ?>

<div class="content_panel">
  <p class="usettings_H">
    This information is used soley for market research purposes.
    Your identity is kept confidential and will NEVER be shared outside of limelight.
  </p>
  <ul class="usettings rnd_3" data-action="<?php echo url_for('user_setting_update') ?>">
    <li class="rnd_3">
      <label>first name</label>
      <input type="text" maxlength="30" class="rnd_3 settingE" data-setting="first_name" value="<?php echo $user->Profile->first_name ?>"></input>
    </li>
    <li class="rnd_3">
      <label>last name</label>
      <input type="text" maxlength="30" class="rnd_3 settingE" data-setting="last_name" value="<?php echo $user->Profile->last_name ?>"></input>
    </li>
    <li class="rnd_3">
      <label>zipcode</label>
      <input type="text" maxlength="15" class="rnd_3 settingE" data-setting="zipcode" value="<?php echo $user->Profile->zipcode ?>"></input>
    </li>
    <li class="rnd_3">
      <label>gender</label>
      <select class="rnd_3 settingE" data-setting="gender">
        <?php
        $genderSelected = array('', '');
        if ($user->Profile->gender == 'male')
          $genderSelected[0] = 'selected';
        else if ($user->Profile->gender == 'female')
          $genderSelected[1] = 'selected';
        ?>
        <option></option>
        <option <?php echo $genderSelected[0] ?>>male</option>
        <option <?php echo $genderSelected[1] ?>>female</option>
      </select>
    </li>
    <li class="rnd_3">
      <label>age</label>
      <select class="rnd_3 settingE" data-setting="age_range">
        <?php
          $ageSelected = array('', '', '', '', '', '', '', '');
          if ($user->Profile->age_range == '10 - 15')
            $ageSelected[0] = 'selected';
          else if ($user->Profile->age_range == '16 - 20')
            $ageSelected[1] = 'selected';
          else if ($user->Profile->age_range == '21 - 25')
            $ageSelected[2] = 'selected';
          else if ($user->Profile->age_range == '26 - 30')
            $ageSelected[3] = 'selected';
          else if ($user->Profile->age_range == '31 - 40')
            $ageSelected[4] = 'selected';
          else if ($user->Profile->age_range == '41 - 50')
            $ageSelected[5] = 'selected';
          else if ($user->Profile->age_range == '51 - 70')
            $ageSelected[6] = 'selected';
          else if ($user->Profile->age_range == '71+')
            $ageSelected[7] = 'selected';
        ?>
        <option></option>
        <option <?php echo $ageSelected[0] ?>>10 - 15</option>
        <option <?php echo $ageSelected[1] ?>>16 - 20</option>
        <option <?php echo $ageSelected[2] ?>>21 - 25</option>
        <option <?php echo $ageSelected[3] ?>>26 - 30</option>
        <option <?php echo $ageSelected[4] ?>>31 - 40</option>
        <option <?php echo $ageSelected[5] ?>>41 - 50</option>
        <option <?php echo $ageSelected[6] ?>>51 - 70</option>
        <option <?php echo $ageSelected[7] ?>>71+</option>
      </select>
    </li>
    <li class="rnd_3">
      <label>income range (per year)</label>
      <select class="rnd_3 settingE" data-setting="income_range">
        <?php
          $irSelected = array('', '', '', '', '', '', '');
          if ($user->Profile->income_range == '< 10k')
            $irSelected[0] = 'selected';
          else if ($user->Profile->income_range == '11 - 40k')
            $irSelected[1] = 'selected';
          else if ($user->Profile->income_range == '41 - 60k')
            $irSelected[2] = 'selected';
          else if ($user->Profile->income_range == '61 - 80k')
            $irSelected[3] = 'selected';
          else if ($user->Profile->income_range == '81 - 100k')
            $irSelected[4] = 'selected';
          else if ($user->Profile->income_range == '101 - 150k')
            $irSelected[5] = 'selected';
          else if ($user->Profile->income_range == '150k+')
            $irSelected[6] = 'selected';
        ?>
        <option></option>
        <option <?php echo $irSelected[0] ?>>< 10k</option>
        <option <?php echo $irSelected[1] ?>>11 - 40k</option>
        <option <?php echo $irSelected[2] ?>>41 - 60k</option>
        <option <?php echo $irSelected[3] ?>>61 - 80k</option>
        <option <?php echo $irSelected[4] ?>>81 - 100k</option>
        <option <?php echo $irSelected[5] ?>>101 - 150k</option>
        <option <?php echo $irSelected[6] ?>>151k+</option>
      </select>
    </li>
  </ul>
</div>