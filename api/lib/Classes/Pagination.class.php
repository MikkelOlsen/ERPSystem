<?php

class Pagination extends Database
{


    public static $items = [];
    public static $limit = 3;
    public static $offset = 1;

    public static function Init(array $items)
    {
        self::$items = $items;
    }

    public static function Items($offset = 1, $limit = 5)
    {
        self::$limit = $limit;
        $itemsCount = count(self::$items);
        $itemOffset = (int)(ceil(self::$limit * $offset));
        $currentItem = $itemOffset - self::$limit;
        $output = [];
        for($currentItem; $currentItem < $itemOffset; $currentItem++){
            if(isset(self::$items[$currentItem])){
                $output[] = self::$items[$currentItem];
            }
        }
        return $output;
    }

    public static function Pages() 
    {
        return (int)(ceil(count(self::$items) / self::$limit));
    }
    

}