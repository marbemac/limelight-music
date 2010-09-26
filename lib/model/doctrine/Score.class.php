<?php

/**
 * Score
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class Score extends BaseScore
{
  public function postInsert($event) {
    // what types of items contribute to a limelights score?
    $limelight_contribute = array('News', 'LimelightWiki', 'LimelightReviewUser', 'LimelightReviewPro', 'LimelightProCon', 'LimelightSpecification', 'NewsLink');
    // what types of items contribute to a users score?
    $user_contribute = array('News', 'LimelightWiki', 'NewsTag', 'LimelightProCon', 'LimelightSpecification', 'Comment');

    $item = $this->Item;
    $item_type = get_class($item);

    // lets check to see if it's this users first downvote. If it is, give them the critic badge!
    if ($this->amount < 0)
    {
      $previous_score = $this->getTable()->checkFirstUserDownvote($this->user_id);
      if (!$previous_score)
      {
        Doctrine::getTable('Badge')->increaseBadgeStat('Critic', $this->user_id);
      }
    }

    // make sure this item isn't directly connected to a limelight
    if ($item_type == 'Limelight')
    {
      $ls = new LimelightScore();
      $ls->type = $item_type;
      $ls->item_id = $item->id;
      $ls->user_id = $this->user_id;
      $ls->amount = $this->amount;
      $ls->save();
    }
    else
    {
      if (($item->score + $this->amount) >= sfConfig::get('app_badge_'.get_class($this).'_min'))
        if ($item->score < sfConfig::get('app_badge_'.get_class($this).'_min', 999999))
          Doctrine::getTable('Badge')->increaseBadgeStat(sfConfig::get('app_badge_'.get_class($this).'_add'), $item->user_id);
      else if (($item->score + $this->amount) < sfConfig::get('app_badge_'.get_class($this).'_min'))
        if ($item->score >= sfConfig::get('app_badge_'.get_class($this).'_min'))
          Doctrine::getTable('Badge')->decreaseBadgeStat(sfConfig::get('app_badge_'.get_class($this).'_add'), $item->user_id);

      $item->score += $this->amount;

      // flag the item if it's below the score threshold
      if ($item->score <= sfConfig::get('app_'.$item_type.'_flag_val')) {
        $item->status = 'Flagged';
        $item->save();
      }

      $item->save();

      // does this item contribute to a users score?
      if (in_array($item_type, $user_contribute))
      {
        $us = new UserScore();
        $us->type = get_class($item);
        $us->user_id = $this->user_id;
        $us->target_user_id = $item->user_id;
        $us->item_id = $item->id;
        $us->amount = $this->amount;
        $us->save();
      }

      // does this item contribute to limelight scores?
      if (in_array($item_type, $limelight_contribute))
      {
        // is it an item that has a many-many limelight relationship?
        if ($item_type == 'News')
        {
          $limelights = $item->Limelights;
          foreach ($limelights as $limelight)
          {
            $ls = new LimelightScore();
            $ls->type = get_class($item);
            $ls->item_id = $limelight->id;
            $ls->contributing_item_id = $item->id;
            $ls->amount = $this->amount;
            $ls->save();
          }
        }
        else if ($item_type == 'NewsLink')
        {
          $ls = new LimelightScore();
          $ls->type = get_class($item);
          $ls->item_id = $item->Source->id;
          $ls->contributing_item_id = $item->id;
          $ls->amount = $this->amount;
          $ls->save();
        }
        else
        {
          $ls = new LimelightScore();
          $ls->type = get_class($item);
          $ls->item_id = $item->item_id;
          $ls->contributing_item_id = $item->id;
          $ls->amount = $this->amount;
          $ls->save();
        }
      }
    }
  }

}