<?php

class commentComponents extends sfComponents
{
  // Takes two parameters, type and id. Both required.
  public function executeShowComments()
  {
    $user = $this->getUser();
    if ($user->isAuthenticated())
      $user_id = $user->getGuardUser()->id;
    else
      $user_id = 0;
    $commentTable = Doctrine::getTable('Comment');
    $this->comments = $commentTable->getComments($this->item['id'], $this->type);
    $this->form = new CommentForm();
  }
}