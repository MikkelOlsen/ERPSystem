<?php
  echo "Hello World! - Heroku works!</br> TEST v4 </br>";

$url = parse_url(getenv("mysql://b84ca7ccb58e60:e465574d@eu-cdbr-west-03.cleardb.net/heroku_d892474fb75fe82?reconnect=true"));

  var_dump($url);

  var_dump(Invoice::getInvoice());
 ?>
