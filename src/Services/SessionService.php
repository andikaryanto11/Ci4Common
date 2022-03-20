<?php

namespace Ci4Common\Services;

use Ci4Common\Libraries\SessionLib;

class SessionService implements SessionServiceInterface
{
    /**
     * @inheritdoc
     */
    public function get($key)
    {
        return SessionLib::get($key);
    }

    /**
     * @inheritdoc
     */
    public function set($key, $value)
    {
        return SessionLib::set($key, $value);
    }

    /**
     * @inheritdoc
     */
    public function remove($key)
    {
        return SessionLib::remove($key);
    }

    /**
     * @inheritDoc
     */
    public function setFlashdata($key, $message)
    {
        SessionLib::setFlashdata($key, $message);
    }
}
