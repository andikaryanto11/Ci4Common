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
     * @inheritDoc
     */
    public function setFlashdata($key, $message)
    {
        SessionLib::setFlashdata($key, $message);
    }
}
