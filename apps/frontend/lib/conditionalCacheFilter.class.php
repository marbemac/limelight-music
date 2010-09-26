<?php
class conditionalCacheFilter extends sfFilter
{
  public function execute($filterChain)
  {
    $context = $this->getContext();
    if (!$context->getUser()->isAuthenticated())
    {
      $cacheManager = $context->getViewCacheManager();
      foreach ($this->getParameter('pages') as $page)
      {
        if ($cacheManager)
          $cacheManager->addCache($page['module'], $page['action'], array('lifeTime' => 180, 'with_layout' => true));
      }
    }

    // Execute next filter
    $filterChain->execute();
  }
}
?>
