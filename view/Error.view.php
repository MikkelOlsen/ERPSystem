<?php

if(file_exists(__DIR__ . DS . 'Error' . DS . Router::GetParamByName('ERROR_ID') . '.view.php'))
    {
        require_once __DIR__ . DS . 'Error' . DS . Router::GetParamByName('ERROR_ID') . '.view.php';
    }else{
        header("HTTP/1.0 404 Not Found");
        exit;
    }