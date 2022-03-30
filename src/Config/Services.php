<?php

namespace Ci4Common\Config;

use Ci4Common\Override\Request;
use Ci4Common\Override\Routes;
use Ci4Common\Override\Session;
use Ci4Common\Shared\Container;
use CodeIgniter\Config\Services as CoreServices;
use CodeIgniter\HTTP\UserAgent;
use Config\App;

class Services extends CoreServices
{
	public static function container($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('container');
        }

        return (new Container())->getContainerBuilder();
    }

    /**
     *
     * @param boolean $getShared
     * @return Routes
     */
    public static function routes(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('routes');
        }

        return new Routes(static::locator(), config('Modules'));
    }

    /**
     *
     * @param boolean $getShared
     * @return Request
     */
    public static function request(App $config = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('request', $config);
        }

        $config = $config ?? config('App');

        return new Request(
            $config,
            static::uri(),
            'php://input',
            new UserAgent()
        );
    }

    /**
     *
     * @param App|null $config
     * @param boolean $getShared
     * @return void
     */
    public static function session(App $config = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('session', $config);
        }

        $config = $config ?? config('App');
        $logger = static::logger();

        $driverName = $config->sessionDriver;
        $driver     = new $driverName($config, static::request()->getIPAddress());
        $driver->setLogger($logger);

        $session = new Session($driver, $config);
        $session->setLogger($logger);

        if (session_status() === PHP_SESSION_NONE) {
            $session->start();
        }

        return $session;
    }
}
