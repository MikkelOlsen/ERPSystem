<?php

class Filter
{
    /**
    * Checks if given method is available and then sanitizes it.
    *
    * @param string $input
    * @return bool
    */
    public static function CheckMethod($input){
        return (
            filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_SPECIAL_CHARS) === strtoupper($input) 
        ) ? true : false;
    }

    /**
    * Returns sanitized array given from param.
    *
    * @param array $arr
    * @return void
    */
    public static function SanitizeArray($arr){
        return filter_input_array(strtoupper($arr), FILTER_SANITIZE_SPECIAL_CHARS);
    }

    /**
     * Returns sanatized URL given from param.
     *
     * @param [type] $url
     * @return void
     */
    public static function SanitizeURL($url)
    {
        return filter_var($url, FILTER_SANITIZE_URL);
    }
}
