<?php

namespace Ci4Common\Libraries;

class RequestLib
{
    public static function getInstance()
    {
        return \Config\Services::request();
    }
}
