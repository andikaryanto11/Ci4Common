<?php

namespace Ci4Common\Config;

use Ci4Common\Override\Routes;
use CodeIgniter\Config\Services as CoreServices;

class Services extends CoreServices
{
    public static function routes(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('routes');
        }

        return new Routes(static::locator(), config('Modules'));
    }
}
