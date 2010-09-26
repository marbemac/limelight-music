<?php

class LimelightWikiFlagTable extends FlagTable
{
  public function flag($user_id, $wiki_id, $flag_type, $disable)
  {
    $date = date('Y-m-d', time());

    // Check to see if the item has already been flagged by this user
    $q = Doctrine_Query::create()
        ->select('id')
        ->from('LimelightWikiFlags')
        ->where('limelight_wiki_id = ? AND user_id = ?', array($wiki_id, $user_id));
    $result = $q->fetchOne();

    if ($result && !$disable)
      return false;

    $fn = new LimelightWikiFlags();
    $fn->flag_type = $flag_type;
    $fn->user_id = $user_id;
    $fn->limelight_wiki_id = $wiki_id;
    $fn->save();

    $q = Doctrine_Query::create()
        ->select('count(id) AS flag_count')
        ->from('LimelightWikiFlags')
        ->where('limelight_wiki_id = ? AND flag_type = ?', array($wiki_id, $flag_type));
    $result = $q->fetchOne();

    $data = array('wiki' => $fn->LimelightWiki, 'disabled' => $user_id);

    if($result['flag_count'] >= sfConfig::get('app_wiki_flag_val') || $disable) {
      if ($fn->LimelightWiki->active == 1)
      {
        $fn->LimelightWiki->active = 0;
        $fn->LimelightWiki->status = 'Flagged';
        $wiki_id = Doctrine::getTable('LimelightWiki')->getMaxNonActiveVersion($fn->LimelightWiki->limelight_id);
        if ($wiki_id) {
          Doctrine_Query::create()
          ->update('LimelightWiki lw')
          ->set('lw.active', '?', true)
          ->where('lw.id = ?', $wiki_id)
          ->execute();
        }
      }

      if ($disable)
      {
        $fn->LimelightWiki->status = 'Disabled';
        $data['disabled'] = '*';
      }
    }

    $fn->LimelightWiki->save();

    return $data;
  }
}