<?php

class distributeUserPointsTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('amount', null, sfCommandOption::PARAMETER_REQUIRED, 'How many points to distribute', 10),
      new sfCommandOption('top_user_cutoff', null, sfCommandOption::PARAMETER_REQUIRED, 'What percentage of users to count in the top users group (1-100)'),
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'default'),
    ));

    $this->namespace        = 'limelight';
    $this->name             = 'distribute-user-points';
    $this->briefDescription = 'Calculate and distribute user points';
    $this->detailedDescription = <<<EOF
The [distribute-user-points|INFO] task calculates the popularity for each user, and distributes points to the top user accounts.
Call it with:

  [php symfony limelight:distribute-user-points|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    $distribution_amount = $options['amount'];
    $cutoff_percent = $options['top_user_cutoff']/100;

    // dont proceed if we haven't inputted the critical values
    if (!$cutoff_percent || !$distribution_amount)
    {
      $this->logSection('top-user-points', 'ERROR: You have to put in a --amount --top_user_cutoff');
      exit();
    }

    $user_table = Doctrine::getTable('sfGuardUser');
    $users = $user_table->getUsersForPointsDistribution();

    $users_popularity;
    foreach ($users as $key => $user)
    {
      $users_popularity[$user['id']] = Doctrine::getTable('sfGuardUser')->generatePopularity($user['id']);
    }

    asort($users_popularity);
    $users_popularity = array_reverse($users_popularity, true);
    $top_user_count = floor(count($users_popularity)*$cutoff_percent);

    // calculate the total popularity of the top users
    $i = 0;
    $top_users_popularity = 0;
    foreach ($users_popularity as $user_id => $popularity)
    {
      // congrats! they made the top users, add their popularity to the top_user_popularity_amount
      if ($i < $top_user_count)
      {
        $top_users_popularity += $popularity;
      }
      else
      {
        continue;
      }
      $i++;
    }

    // insert all of the distribution rows (one for each user!)
    $i = 0;
    $total_claim = 0;
    $total_top_users = 0;
    foreach ($users_popularity as $user_id => $popularity)
    {
      $claim_amount = 0.0;
      // calculate their claim amount
      if ($i < $top_user_count)
      {
        $claim_amount = floor(($popularity/$top_users_popularity)*$distribution_amount);
        $total_top_users += 1;
      }

      $ur = new UserRevenue();
      $ur->amount = $claim_amount;
      $ur->popularity = $popularity;
      $ur->user_id = $user_id;
      $ur->save();

      // add a notification if they got some money
      if ($claim_amount > 0)
      {
        $un = new UserNotification();
        $un->message = 'Congrats, you got $'.$claim_amount.' in the last revenue distribution! Check it out in the \'stats & revenue\' tab of your account';
        $un->type = 'revenue';
        $un->user_id = $user_id;
        $un->save();
      }

      $total_claim += $claim_amount;
      $i++;
    }

    $this->logSection('top-user-points', 'Distributed '.$total_claim.' total user points to '.$total_top_users.' users on '.date('M d, y', time()));
  }
}
