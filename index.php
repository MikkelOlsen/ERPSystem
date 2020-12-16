<?php
    /**
     * Require the init file to startup the webpage
     * Then initialize the Router, thus finding what page should be displayed.
     * Require the correct layout for the requested URL (the layour requires the correct view file)
     */
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'init.php';
    Router::init($_SERVER['REQUEST_URI'], ROUTES);
    CONST ROOT = __DIR__;
    require_once ROOT . DS . 'lib' . DS .'Layouts' . DS . Router::$Layout . '.layout.php';
    
