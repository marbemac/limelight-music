<?php


class BetaGiveawayTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('BetaGiveaway');
    }

    public function getChance()
    {
      $group_code = sfConfig::get('app_beta_giveaway_group_code');
      $q = Doctrine_Query::create()
          ->select('guess, COUNT(guess) AS count')
          ->from('BetaGiveaway')
          ->where('group_code = ?', $group_code)
          ->groupBy('guess')
          ->orderBy('count DESC');
      $result = $q->fetchOne();

      if (!$result)
        return 100;

      $number = (int)$result['count'];
      if ($number == 0)
        return 100;
      else
        return floor(1/($number+1)*100);
    }

    public function checkSubmission($email_id)
    {
      $q = Doctrine_Query::create()
          ->select('id')
          ->from('BetaGiveaway')
          ->where('beta_email_id = ? AND group_code = ?', array($email_id, sfConfig::get('app_beta_giveaway_group_code')));
      return $q->fetchArray();
    }
}