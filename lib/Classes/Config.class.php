<?php

class Config 
{
    /**
     * Locate and return all files in the directory given as a prameter, which ends with the filetype parameter.
     *
     * @param [type] $dir
     * @param string $fileType
     * @return array
     */
    public static function LocateFiles($dir, string $fileType = '.config.php') : array
    {
        try
        {
            if(is_dir($dir)){
                return glob($dir . '*' . $fileType);
            }
        }
        catch(Exception $e)
        {
            return ['error'];
        }
        return [];
    }
}
