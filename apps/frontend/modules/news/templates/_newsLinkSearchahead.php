[
<?php

foreach ($items as $key => $link)
{
  echo '"'.$link['source_name'].'"';
  if (isset($items[$key+1]))
    echo ',';
}

?>
]