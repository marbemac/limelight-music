<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
<?php

        // put your code here
        $cache = new Memcache();

        $cache->connect("127.0.0.1");
        //addServer("127.0.0.1",11211);
        $user_key = 12345;

    /** Look in cache, if not found, set object (misses null) **/
    if (!$user = $cache->get($user_key)) {
      /**
       * Set object with expire of 1 hour and no compression
       */
      $value = array(34,56,34,23,23,124,65,767,34,76576,99);
      $cache->set($user_key, $value, NULL, 6000);
      $user = $value;
      echo "In";
    }
    else
    {
            $tVar = $cache->get($user_key);
        echo '<PRE>';
        print_r($tVar);
        echo "Out";
    }
        ?>
    </body>
</html>