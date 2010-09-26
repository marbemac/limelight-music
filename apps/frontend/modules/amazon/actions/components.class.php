<?php
class amazonComponents extends sfComponents
{
  public function executeLimelightProducts()
  {
    if ($this->limelight->limelight_type == 'Company')
    {
      return sfView::NONE;
    }

    $categories = Doctrine::getTable('Limelight')->getCategories($this->limelight->id);

    $amazon_cat = null;
    foreach ($categories['Categories'] as $cat)
    {
      if ($cat['amazon_category'] != NULL)
      {
        $amazon_cat = $cat['amazon_category'];
        break;
      }
    }

    if (!$amazon_cat)
    {
      return sfView::NONE;
    }

    $this->amazon_cat = $amazon_cat;
    $this->keyword = $this->limelight->name;
  }
}