<?php
class songComponents extends sfComponents
{
  // build the daily views/score chart
  public function executeChartScoreView()
  {
    $scoreData = Doctrine::getTable('Score')->getScoreChartData('news', $this->id);
    $viewData = Doctrine::getTable('View')->getViewChartData('news', $this->id);

    $this->data = LimelightUtils::executeChart(array($scoreData, $viewData), 'news');
  }

  public function executeAddForm()
  {
    $this->form = new NewsForm();
  }

}