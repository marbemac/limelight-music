<?php
class limelightComponents extends sfComponents
{
  public function executeTopLimelights()
  {
    $this->limelights1 = Doctrine::getTable('Limelight')->getTopLimelights(sfConfig::get('app_toplimelights_limit'), 1);
    $this->limelights7 = Doctrine::getTable('Limelight')->getTopLimelights(sfConfig::get('app_toplimelights_limit'), 7);
    $this->limelights30 = Doctrine::getTable('Limelight')->getTopLimelights(sfConfig::get('app_toplimelights_limit'), 30);
    $this->limelights0 = Doctrine::getTable('Limelight')->getTopLimelights(sfConfig::get('app_toplimelights_limit'), 0);
  }

  public function executeStats()
  {

  }

  public function executeLimelightCategories()
  {
    $this->categories = Doctrine::getTable('Limelight')->getCategories($this->limelight->id);
  }

  // build the daily views/score chart
  public function executeChartScoreView()
  {
    $scoreData = Doctrine::getTable('Score')->getScoreChartData('limelight', $this->id);
    $viewData = Doctrine::getTable('View')->getViewChartData('limelight', $this->id);

    $this->data = LimelightUtils::executeChart(array($scoreData, $viewData), 'limelight');
  }

  // build the chart showing new daily items
  public function executeChartNewItems()
  {
    $newsData = Doctrine::getTable('Limelight')->getLimelightNewsChartData($this->id);
    //$reviewData = Doctrine::getTable('Limelight')->getLimelightReviewChartData($this->id);
    //$wikiData = Doctrine::getTable('Limelight')->getLimelightWikiChartData($this->id);

    $this->data = LimelightUtils::executeChart(array($newsData), 'limelight');
  }

  public function executeLimelightLink()
  {
    $this->limelight = Doctrine::getTable('Limelight')->getLimelight($this->id);
    if (!isset($this->link_name)) {
      if ($this->limelight['company_name'])
        $this->link_name = $this->limelight['company_name'].' '.$this->limelight['name'];
      else
        $this->link_name = $this->limelight['name'];
    }

    if (isset($this->pic) && $this->pic != null)
    {
      if ($this->limelight['profile_image'])
        $this->image = '<img src="'.sfConfig::get('app_limelight_image_path').'/thumb/'.$this->limelight['profile_image'].'" />';
      else
        $this->image = '<img src="'.sfConfig::get('app_limelight_image_path').'/thumb/limelight_profile_default.gif" />';
    }
    else
      $this->image = '';

    $this->my = isset($this->my) ? $this->my : 'bottom center';
    $this->at = isset($this->at) ? $this->at : 'top center';

    if (isset($this->score_increase) && $this->score_increase != null)
      $this->score_increase = '<span class="score_increase rnd_3">'.($this->score_increase >= 0 ? '+' : '' ).$this->score_increase.'</span>';
    else
      $this->score_increase = '';
  }
  
  public function executeLimelightHead()
  {
    $user = $this->getUser();
    $user_id = $user->isAuthenticated() ? $user->getGuardUser()->id : 0;
//    $this->tags = Doctrine::getTable('LimelightTag')->getTags($this->limelight['id']);
    $this->limelightStats = Doctrine::getTable('Limelight')->getLimelightStats($this->limelight['id'], $this->user_id);
  }

  public function executeStubStats()
  {
    $this->stub_stats = Doctrine::getTable('Limelight')->getStubStats($this->limelight['id']);
  }

  public function executeSlices()
  {
    $this->sliceForm = new LimelightSliceForm();
  }

  public function executeSpecifications()
  {
    $this->user_id = $this->getUser()->isAuthenticated() ? $this->getUser()->getGuardUser()->id : 0;
    $this->specifications = Doctrine::getTable('Limelight')->getSpecifications($this->limelight->id, $this->user_id);
    $this->specificationForm = new LimelightSpecificationForm($this->limelight['id'], $this->limelight['name']);
  }

  public function executePros()
  {
    $this->pros = Doctrine::getTable('LimelightProCon')->getProsCons($this->limelight['id'], 'pro');
    $this->form = new LimelightProConForm($this->limelight['id'], $this->limelight['name']);
  }

  public function executeCons()
  {
    $this->cons = Doctrine::getTable('LimelightProCon')->getProsCons($this->limelight['id'], 'con');
    $this->form = new LimelightProConForm($this->limelight['id'], $this->limelight['name']);
  }
}