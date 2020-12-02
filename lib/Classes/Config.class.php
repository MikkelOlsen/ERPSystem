<?php

class Config 
{
    public static function LocateFiles($dir)
    {
        try
        {
            if(is_dir($dir)){
                return glob($dir . '*.config.php');
            }
        }
        catch(Exception $e)
        {
            return ['error'];
        }
        return [];
    }
}
