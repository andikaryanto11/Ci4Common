<?php

class StringLib
{
    public static function getRandom($length = 3)
    {
         $characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
         $charactersLength = strlen($characters);
         $randomString     = '';
        for ($i = 0; $i < $length; $i++) {
             $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
         return $randomString;
    }
}
