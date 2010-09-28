<?php
class viewsFilter extends sfFilter
{
  public function execute($filterChain)
  {
    // Execute this filter only once
    if ($this->isFirstCall())
    {
      // Filters don't have direct access to the request and user objects.
      // You will need to use the context object to get them
      $request = $this->getContext()->getRequest();

      $module = $request->getRequestParameters();
      $module = $module['module'];

      // Only proceed if we are looking at a news story or limelight page
      if (!$request->isXmlHttpRequest() && (in_array($module, array('news', 'limelight', 'song', 'user')))) {
        $userID = $this->getContext()->getUser()->getGuardUser();
        $userID = isset($userID) ? $userID->id : 1; // 1 is anon user

        $date = date('Y-m-d', time());

        if ($module == 'user' && $request->hasParameter('username') && $request->getParameter('page', null) != 'tab') {
          $param = $request->getParameter('username');
          $targetuser = Doctrine::getTable('UserView')->getUserDailyViews($param, $userID, $date);
          if ($targetuser->id != $userID) {
            if (count($targetuser->Views) == 0) {
              $dv = new UserView();
              $dv->target_user_id = $targetuser->id;
              $dv->user_id = $userID;
              $dv->save();
            } else {
              $targetuser->Views[0]->count += 1;
            }
            $targetuser->Profile->total_views += 1;
            $targetuser->save();
          }
        } else if ($module == 'news' && $request->hasParameter('title')) {
          $param = $request->getParameter('title_slug');
          $news = Doctrine::getTable('NewsView')->getUserDailyViews($param, $userID, $date);
          if (count($news->Views) == 0) {
            $dv = new NewsView();
            $dv->item_id = $news->id;
            $dv->user_id = $userID;
            $dv->save();
          } else {
            $news->Views[0]->count += 1;
          }
          $news->total_views += 1;
          $news->save();
        } else if ($module == 'limelight' && $request->hasParameter('name_slug')) {
          $param = $request->getParameter('name_slug');
          $limelight = Doctrine::getTable('LimelightView')->getUserDailyViews($param, $userID, $date);
          if (count($limelight->Views) == 0) {
            $dv = new LimelightView();
            $dv->item_id = $limelight->id;
            $dv->user_id = $userID;
            $dv->save();
          } else {
            $limelight->Views[0]->count += 1;
          }
          $limelight->total_views += 1;
          $limelight->save();
        } else if ($module == 'song' && $request->hasParameter('name_slug')) {
          $param = $request->getParameter('name_slug');
          $song = Doctrine::getTable('SongView')->getUserDailyViews($param, $userID, $date);
          if (count($song->Views) == 0) {
            $dv = new SongView();
            $dv->item_id = $song->id;
            $dv->user_id = $userID;
            $dv->save();
          } else {
            $song->Views[0]->count += 1;
          }
          $song->total_views += 1;
          $song->save();
        }
      }
    }

    // Execute next filter
    $filterChain->execute();
  }
}
?>
