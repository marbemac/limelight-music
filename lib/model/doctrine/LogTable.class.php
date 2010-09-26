<?php

class LogTable extends Doctrine_Table
{
  public function newLog($type, $message, $user_id, $ip) {
    if (!$type || !$message)
      return false;

    $l = new Log();
    $l->type = $type;
    $l->message = $message;
    $l->user_id = $user_id;
    $l->ip_address = $ip;
    $l->save();
  }
}