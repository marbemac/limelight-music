<?php

/**
 * rankings actions.
 *
 * @package    limelight
 * @subpackage rankings
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class rankingsActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeShow()
  {
    $this->users1 = Doctrine::getTable('sfGuardUserProfile')->getTopUsers(1);
    $this->limelights1 = Doctrine::getTable('Limelight')->getTopLimelights(1);
    $this->newss1 = Doctrine::getTable('News')->getTopNews(1);
    $this->users7 = Doctrine::getTable('sfGuardUserProfile')->getTopUsers(7);
    $this->limelights7 = Doctrine::getTable('Limelight')->getTopLimelights(7);
    $this->newss7 = Doctrine::getTable('News')->getTopNews(7);
    $this->users30 = Doctrine::getTable('sfGuardUserProfile')->getTopUsers(30);
    $this->limelights30 = Doctrine::getTable('Limelight')->getTopLimelights(30);
    $this->newss30 = Doctrine::getTable('News')->getTopNews(30);
  }

  public function executeRankingsFeed($request)
  {
    $period = $request->getParameter('period');
    $this->users = Doctrine::getTable('sfGuardUserProfile')->getTopUsers($period);
    $this->limelights = Doctrine::getTable('Limelight')->getTopLimelights($period);
    $this->newss = Doctrine::getTable('News')->getTopNews($period);
  }
}
