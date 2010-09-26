<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register(); 

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins(array(
      'sfDoctrinePlugin',
      'sfDoctrineGuardPlugin',
      'sfFormExtraPlugin',
      'sfThumbnailPlugin'
    ));
  }

  static protected $zendLoaded = false;

  static public function registerZend()
  {
    if (self::$zendLoaded)
    {
      return;
    }

    set_include_path(sfConfig::get('sf_lib_dir').'/vendor'.PATH_SEPARATOR.get_include_path());
    require_once sfConfig::get('sf_lib_dir').'/vendor/Zend/Loader/Autoloader.php';
    Zend_Loader_Autoloader::getInstance();
    self::$zendLoaded = true;
  }

  public function configureDoctrine(Doctrine_Manager $manager)
  {
    if (sfConfig::get('sf_environment') == 'prod' || sfConfig::get('sf_environment') == 'staging' || sfConfig::get('sf_environment') == 'test')
    {
      //$cacheDriver = new Doctrine_Cache_Apc(); temp out
      $cacheDriver = new Doctrine_Cache_Array();
    }
    else
    {
      $cacheDriver = new Doctrine_Cache_Array();
    }
// possible memcached config
//    $servers = array(
//      'host' => '127.0.0.1',
//      'port' => 11211,
//      'persistent' => true
//    );
//    $cacheDriver = new Doctrine_Cache_Memcache(array(
//      'servers' => $servers,
//      'compression' => false
//    ));

    $manager->setAttribute(Doctrine::ATTR_RESULT_CACHE, $cacheDriver);
    $manager->setAttribute(Doctrine_Core::ATTR_RESULT_CACHE_LIFESPAN, 60);
  }
}