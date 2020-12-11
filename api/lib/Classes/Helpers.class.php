<?php
class Helpers
{
    public static function array_key_exists_r(array $keys, array $search_r) : bool
    {
        $errors = 0;
        foreach($keys as $key)
        {
            if(!array_key_exists($key,$search_r))
            {
                $errors++;
            }
        }
        return ( $errors === 0 );
    }
}