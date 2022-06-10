<?php

namespace Ci4Common\Libraries;

class SessionLib
{
    public static function set($key, $value)
    {
        $newkey = CommonLib::encryptMd5(CommonLib::getKey() . $key);
        session()->set([$newkey => $value]);
    }

    public static function get($key)
    {
        $newkey = CommonLib::encryptMd5(CommonLib::getKey() . $key);
        return session($newkey);
    }

    public static function remove($key)
    {
        $newkey = CommonLib::encryptMd5(CommonLib::getKey() . $key);
        session()->remove($newkey);
    }

    public static function setFlashdata($key, $message)
    {
        $newkey = CommonLib::encryptMd5(CommonLib::getKey() . $key);
        session()->setFlashdata($newkey, $message);
    }

    public static function destroy()
    {
        session()->destroy();
    }
}
