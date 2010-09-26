<?php
class reviewsComponents extends sfComponents
{
  public function executeProReviews()
  {
    $this->reviews = Doctrine::getTable('LimelightReviewPro')->findByDql('limelight_id = ? AND status = ?', array($this->limelight['id'], 'Active'));
  }

  public function executeUserReviews()
  {
    $user = $this->getUser();
    if ($user->isAuthenticated())
        $user_id = $user->getGuardUser()->id;
    else
        $user_id = 0;

    if (!isset($this->reviews))
      $this->reviews = Doctrine::getTable('LimelightReviewUser')->getReviews($this->ll_id, $user_id, 0);
  }
}