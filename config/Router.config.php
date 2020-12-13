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
      'path' => '/Test',
      'view' => 'Frontend'.DS.'Dashboard.view.php'
    ],
    [
      'path' => '/Services',
      'view' => 'Api'.DS.'Services.view.php',
      'layout' => 'Api'
    ],
    [
      'path' => '/Api/Invoice',
      'view' => 'Api'.DS.'Invoice.view.php',
      'layout' => 'Api'
    ]
  );
?>
