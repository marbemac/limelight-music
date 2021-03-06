<?php

/**
 * Item
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class Item extends BaseItem
{
  public function postInsert($event)
  {
    if (!$this->user_id)
     return;

    $item_type = get_class($this);
    $item_id_column = $item_type.'_id';
    // what types of items contribute to a limelights contribute feed?
    $limelight_contribute = array('LimelightReviewUser', 'LimelightReviewPro', 'LimelightProCon', 'LimelightSpecification');

    $a = new UserAction();
    $a->user_id = $this->user_id;
    $a->$item_id_column = $this->id;
    if (in_array($item_type, $limelight_contribute))
      $a->Limelight_id = $this->Item->id;
    $a->type = $item_type;
    $a->save();

    if ($item_type != 'Limelight' && $item_type != 'NewsTag' && !($item_type == 'Wiki' && $this->edit_type == 'minor'))
    {
      $s = new UserScore();
      $s->amount = 1;
      $s->type = $item_type;
      $s->target_user_id = $this->user_id;
      $s->save();
    }
  }
}