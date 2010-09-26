<?php
class wikiFilter extends sfFilter
{
  public function execute($filterChain)
  {
    // Execute this filter only once
    if ($this->isFirstCall() && !$this->getContext()->getRequest()->isXmlHttpRequest())
    {
      $wiki_id = $this->getContext()->getUser()->getAttribute('wiki_edit', false);
      if ($this->getContext()->getUser()->isAuthenticated() && $wiki_id)
      {
        $wiki = Doctrine::getTable('Wiki')->find($wiki_id);
        $wiki->edit_lock = 0;
        $wiki->edit_lock_start = null;
        $wiki->edit_lock_time = null;
        $wiki->edit_lock_user_id = null;
        $wiki->save();

        $this->getContext()->getUser()->setAttribute('wiki_edit', false);
        $this->getContext()->getUser()->setFlash('notice', 'You reloaded the page. The wiki segment you were editing has been unlocked and any unsaved changes you made have been discarded.');
      }
    }

    // Execute next filter
    $filterChain->execute();
  }
}
?>
