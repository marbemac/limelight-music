<?php

/**
 * news actions.
 *
 * @package    news
 * @subpackage news
 * @author     marc
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class searchActions extends sfActions
{
  public function executePopulateLimelights($request)
  {
    $items = Doctrine::getTable('Limelight')->populateBasicSearch();

    if ($request->getParameter('type') == 'ac')
    {
      $this->renderPartial('populateLimelightsAC.json', array('items' => $items));
      return sfView::NONE;
    }
    else
      $this->setTemplate('populateLimelightsTBL');
  }

  public function executePopulateCompanies($request)
  {
    $items = Doctrine::getTable('Limelight')->populateCompanies();
    $this->renderText(json_encode($items));
    return sfView::NONE;
  }

  public function executePopulateSources($request)
  {
    $items = Doctrine::getTable('Limelight')->populateSources();
    $this->renderText(json_encode($items));
    return sfView::NONE;
  }

  // populate the different specification names
  public function executePopulateLimeSpecifications($request)
  {
    $items = Doctrine::getTable('Specification')->populateLimeSpecifications();
    $this->renderText(json_encode($items));
    return sfView::NONE;
  }

// populate the different pros or cons
  public function executePopulateProsCons($request)
  {
    $items = Doctrine::getTable('LimelightProCon')->populateProsCons($request->getParameter('item_type', null));
    $this->renderText(json_encode($items));
    return sfView::NONE;
  }

  // populate the content of specifications (the actual specification)
  public function executePopulateSpecifications($request)
  {
    $items = Doctrine::getTable('Specification')->populateSpecifications();
    $this->renderText(json_encode($items));
    return sfView::NONE;
  }

  public function executePopulateUsers($request)
  {
    $this->users = Doctrine::getTable('sfGuardUserProfile')->populateBasicSearch();

    if ($request->getParameter('type') == 'ac')
      $this->setTemplate('populateUsersAC');
    else
      $this->setTemplate('populateUsersTBL');
  }

  public function executePopulateTags($request)
  {
    $this->tags = Doctrine::getTable('Tag')->getSearchAheadList();
  
    if ($request->getParameter('type') == 'ac')
      $this->setTemplate('populateTagsAC');
    else
      $this->setTemplate('populateTagsTBL');
  }

  public function executePopulateSpecs($request)
  {
    $this->specs = Doctrine::getTable('LimelightSpec')->populateBasicSearch();

    if ($request->getParameter('type') == 'ac')
      $this->setTemplate('populateSpecsAC');
    else
      $this->setTemplate('populateSpecsTBL');
  }

  public function executeBasicSearch(sfWebRequest $request)
  {
    if (!$query = $request->getParameter('q'))
    {
      return $this->redirect('@homepage');
    }

    if ($this->getUser()->isAuthenticated()) {
      $user_id = $this->getUser()->getGuardUser()->id;
      $this->user = $this->getUser()->getGuardUser()->id;
    } else {
      $user_id = 0;
      $this->user = 'notlogged';
    }

    $this->type = 'News';
    $this->items = Doctrine::getTable('News') ->getForLuceneQuery($query);
  }

  public function executePowerSearch(sfWebRequest $request)
  {
    $this->type = $request->getParameter('type');
  }
}