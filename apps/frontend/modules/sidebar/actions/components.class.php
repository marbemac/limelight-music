<?php

class sidebarComponents extends sfComponents
{
  public function executeDefault()
  {
  }

  public function executeLimelight($request)
  {
    $this->limelight = Doctrine::getTable('Limelight')->getSidebarInfo($request->getParameter('name_slug'));
  }

	public function executeUser()
	{
	}

  public function executeNews()
  {
  }
}