<?php

class cleanupSourcesTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'default'),
    ));

    $this->namespace        = 'limelight';
    $this->name             = 'cleanup-sources';
    $this->briefDescription = 'Changes sources into source limelights';
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    $q = Doctrine_Query::create()
          ->select('*')
          ->from('Source')
          ->orderBy('id DESC');

    $sources = $q->fetchArray();

    foreach ($sources as $source)
    {
      $ll = Doctrine::getTable('Limelight')->findOneByName($source['source_name']);
      if (!$ll)
      {
        $ll = new Limelight();
        $ll->name = $source['source_name'];
        $ll->limelight_type = 'source';
        $ll->user_id = $source['user_id'];
        $ll->created_at = $source['created_at'];
        $ll->updated_at = $source['updated_at'];
        $ll->save();
      }
      
      Doctrine_Query::create()
      ->update('LimelightSpecification')
      ->set('source_id', $ll->id)
      ->where('source_id = ?', $source['id'])
      ->execute();

      Doctrine_Query::create()
      ->update('NewsLink')
      ->set('source_id', $ll->id)
      ->where('source_id = ?', $source['id'])
      ->execute();

      $name = $source['source_name'];

      $this->logSection('done', 'Done with '.$name.' - '.$ll->id.' - '.$source['id'].'!');
    }

    $this->logSection('done', 'Done!');
  }
}
