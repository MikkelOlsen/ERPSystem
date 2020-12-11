<?php

    require_once __DIR__ . DIRECTORY_SEPARATOR . 'init.php';
    Router::init($_SERVER['REQUEST_URI'], ROUTES);
    CONST ROOT = __DIR__;
    require_once ROOT . DS . 'lib' . DS .'Layouts' . DS . Router::$Layout . '.layout.php';

