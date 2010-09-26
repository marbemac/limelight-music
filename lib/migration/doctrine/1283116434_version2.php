<?php

class Version2 extends Doctrine_Migration_Base
{
  public function up()
  {
    //$this->addColumn('sf_guard_user', 'show_welcome_splash', 'bool', null, array('default' => 1));
  }

  public function down()
  {
    $this->removeColumn('sf_guard_user', 'show_welcome_splash');
  }
}
