<?php
namespace App\Helpers;

class DateTime{

    public static function now($format="Y-m-d H:i:s")
    {
        return date($format);
    }


    public static function date($format="Y-m-d")
    {
        return date($format);
    }

    public static function time($format="H:i:s")
    {
        return date($format);
    }

}



