<?php

class Version1 extends Doctrine_Migration_Base
{
  public function up()
  {
    //$this->addColumn('category', 'amazon_category', 'string', 255, array('default' => null));
  }

  public function down()
  {
    $this->removeColumn('category', 'amazon_category');
  }
}
