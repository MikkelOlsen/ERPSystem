<?php
  Router::SetViewFoler(__ROOT__ . DS . 'view' . DS);
  Router::SetDefaultRoute('/Dashboard');
  Router::SetDefaultLayout('Frontend');
  CONST ROUTES = array(
    [
      'path' => '/Dashboard',
      'view' => 'Frontend'.DS.'Dashboard.view.php'
    ]
  );
?>
