<?php


class SpecificationTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Specification');
    }

    public function populateSpecifications()
    {
      $q = Doctrine_Query::create()
          ->select('name')
          ->from('Specification')
          ->where('status = ?', 'Active')
          ->useResultCache(true, 86400, 'specifications');
      return $q->execute(array(), Doctrine::HYDRATE_NONE);
    }

    public function populateLimeSpecifications()
    {
      $q = Doctrine_Query::create()
          ->select('DISTINCT content')
          ->from('LimelightSpecification')
          ->where('status = ?', 'Active')
          ->useResultCache(true, 86400, 'limelight_specifications');
      $results = $q->fetchArray();

      $items = array();
      foreach ($results as $result)
      {
        if ($result['content'] != null && !in_array($result['content'], $items))
          $items[] = $result['content'];
      }

      return $items;
    }

    // handle specification additions
    public function add($name, $user_id)
    {
      $spec = $this->findOneByNameSlug(LimelightUtils::slugify($name));
      if (!$spec) {
        $spec = new Specification();
        $spec->name = $name;
        $spec->user_id = $user_id;
        $spec->save();
      }
      return $spec;
    }
}