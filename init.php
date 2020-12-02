<?php
    setlocale(LC_ALL, array('da_DA.UTF-8','da_DA@euro','da_DA','danish'));

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    define('__DEBUG__', false);
    define('__ROOT__', __DIR__);
    define('DS', DIRECTORY_SEPARATOR);
    define('_CLASSES_', __DIR__.'/lib/Classes');

    session_start();

    spl_autoload_register(function ($className) {
        $className = str_replace('\\', '/', $className);
        if (file_exists(__DIR__ . DS  . 'lib' . DS . 'Classes' . DS . $className . '.class.php')) {
            require_once __DIR__  . DS . 'lib' . DS . 'Classes' . DS . $className . '.class.php';
        } else {
            throw new Exception('ERROR: '. __DIR__ . DS . 'lib' . DS . 'Classes' . DS .  $className . '.class.php');
        }
    });

    $GET  = Filter::CheckMethod('GET')  ? Filter::SanitizeArray(INPUT_GET)  : null;
    $POST = Filter::CheckMethod('POST') ? Filter::SanitizeArray(INPUT_POST) : null;

    foreach (Config::LocateFiles(__ROOT__ . DS . 'config' . DS) as $configFile) {
        require_once $configFile;
    }
