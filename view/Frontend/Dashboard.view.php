<?php
  echo "Hello World! - Heroku works!</br> TEST v2 </br>";

$url = parse_url(getenv("mysql://b1140bd4539d94:dd30aefb@eu-cdbr-west-03.cleardb.net/heroku_10c337ec6ca316c?reconnect=true"));

  var_dump($url);

  var_dump(Invoice::getInvoice());
 ?>
