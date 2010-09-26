<?php

class cleanupTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
    ));

    $this->namespace        = 'limelight';
    $this->name             = 'cleanup';
    $this->briefDescription = 'Cleanup Limelight database and run Lucene Search optimize routine';
    $this->detailedDescription = <<<EOF
The [cleanup|INFO] task does things.
Call it with:

  [php symfony limelight:cleanup|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    // cleanup news Lucene index
    $index = Doctrine::getTable('News')->getLuceneIndex();

    $q = Doctrine_Query::create()
      ->from('News n')
      ->where('n.Status != ?', 'Active');

    $newss = $q->execute();
    foreach ($newss as $news)
    {
      if ($hit = $index->find('pk:'.$news->getId()))
      {
        $hit->delete();
      }
    }

    $index->optimize();

    $this->logSection('lucene', 'Cleaned up and optimized the news index');

    // cleanup wiki segment Lucene index
    $index = Doctrine::getTable('Wiki')->getLuceneIndex();

    $q = Doctrine_Query::create()
      ->from('Wiki w')
      ->where('w.Status != ? OR w.is_active != ?', array('Active', 1));

    $wikis = $q->execute();
    foreach ($wikis as $wiki)
    {
      if ($hit = $index->find('pk:'.$wiki->getId()))
      {
        $hit->delete();
      }
    }

    $index->optimize();

    $this->logSection('lucene', 'Cleaned up and optimized the wiki index');
  }
}
