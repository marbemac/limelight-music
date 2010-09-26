[
<?php
foreach ($items as $key => $tag)
{
  echo '"'.$tag[1].'"';
  if (isset($items[$key+1]))
    echo ',';
}

?>
]