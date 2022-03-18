<?php

namespace Ci4Common\Libraries;

use Illuminate\Support\Facades\Config;

class CommonLib
{
    public static function encryptMd5($string)
    {
        $hash          = md5($string);
        $lastestString = substr($hash, strlen($hash) - 5, 5);
        $newChar       = strrev($lastestString);
        $newString     = substr($hash, 0, strlen($hash) - 5) . $newChar;
        return $newString;
    }

    public static function setIsDecimal($data)
    {
        if (empty($data)) {
            return 0.00;
        } else {
            $data     = str_replace('.', '', $data);
            $newvalue = str_replace(',', '.', $data);
            return $newvalue;
        }
    }

    public static function setIsNumber($data, $default = 0)
    {
        if (empty($data)) {
            return $default;
        } else {
            return $data;
        }
    }

    public static function setBoolean($value)
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    public static function setCurrency($value)
    {
        return number_format($value, 0, ',', '.');
    }

    public static function getKey()
    {
        return getenv('app.key');
    }

    public static function defaultUser()
    {
        return 'super_admin';
    }
}
