<?php

class LimelightProConFlagTable extends FlagTable
{
  public function flag($user_id, $pc_id, $flag_type, $disable)
  {
    $date = date('Y-m-d', time());

    // Check to see if the item has already been flagged by this user
    $q = Doctrine_Query::create()
        ->select('id')
        ->from('LimelightProConFlags')
        ->where('limelightprocon_id = ? AND user_id = ?', array($pc_id, $user_id));
    $result = $q->fetchOne();

    if ($result && !$disable)
      return false;

    $pc = new LimelightProConFlags();
    $pc->flag_type = $flag_type;
    $pc->user_id = $user_id;
    $pc->limelightprocon_id = $pc_id;
    $pc->save();

    $q = Doctrine_Query::create()
        ->select('count(id) AS flag_count')
        ->from('LimelightProConFlags')
        ->where('limelightprocon_id = ? AND flag_type = ?', array($pc_id, $flag_type));
    $result = $q->fetchOne();

    $data = array('procon' => $pc->LimelightProCon, 'disabled' => $user_id);

    if($result['flag_count'] >= sfConfig::get('app_limelight_procon_flag_val') || $disable) {
      if ($disable)
      {
        $pc->LimelightProCon->status = 'Disabled';
        $data['disabled'] = '*';
      }
      else
        $pc->LimelightProCon->status = 'Flagged';
    }

    $pc->LimelightProCon->save();

    return $data;
  }
}