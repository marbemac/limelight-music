<?php

class TagTable extends Doctrine_Table
{
  public function getSearchaheadList() {
    $q = Doctrine_Query::create()
        ->select('id, name')
        ->from('Tag')
        ->where('status = ?', 'Active')
        ->useResultCache(true, 600, 'tag_list');

    return $q->execute(array(), Doctrine::HYDRATE_NONE);
  }

  // given a user_id, news id, add an array of tags (names given)
  // add the tags if they arent already in the DB, and connect them
  // to the news story 
  public function newsAddTags($user_id, $news_id, $tags)
  {
    $tags_slug = array();
    foreach ($tags as $tag)
      $tags_slug[] = LimelightUtils::slugify ($tag);

    $q = Doctrine_Query::create()
        ->select('id, name_slug')
        ->from('Tag')
        ->whereIn('name_slug', $tags_slug);

    $results = $q->execute();

    foreach ($tags_slug as $key => $tag)
    {
      $found = false;
      foreach ($results as $result)
      {
        if ($tag == $result['name_slug'])
        {
          $tag_id = $result['id'];
          $found = true;
        }
      }
      // create the tag if it hasn't been added before
      if (!$found)
      {
          $t = new Tag();
          $t->name = substr($tags[$key], 0, sfConfig::get('app_tag_name_max_length'));
          $t->user_id = $user_id;
          $t->save();
          $tag_id = $t->id;
      }
      // link the news story
      $nt = new NewsTag();
      $nt->user_id = $user_id;
      $nt->tag_id = $tag_id;
      $nt->item_id = $news_id;
      $nt->save();
    }
  }
}