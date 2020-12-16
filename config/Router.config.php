<?php
  Router::SetViewFoler(__ROOT__ . DS . 'view' . DS);
  Router::SetDefaultRoute('/Dashboard');
  Router::SetDefaultLayout('Frontend');
  CONST ROUTES = array(
    [
      'path' => '/Dashboard',
      'view' => 'Frontend'.DS.'Dashboard.view.php'
    ],
    [
      'path' => '/Log',
      'view' => 'Frontend'.DS.'Log.view.php'
    ],
    [
      'path' => '/ServicesAPI',
      'view' => 'Api'.DS.'Services.view.php',
      'layout' => 'Api'
    ],
    [
      'path' => '/InvoiceAPI',
      'view' => 'Api'.DS.'Invoice.view.php',
      'layout' => 'Api'
    ]
  );
?>
