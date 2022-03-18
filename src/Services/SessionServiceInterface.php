<?php

namespace Ci4Common\Services;

interface SessionServiceInterface
{
    /**
     * Get Session By Key
     *
     * @param string $key
     * @return array
     */
    public function get($key);

    /**
     * Set Flash Session By Key
     *
     * @param string $key
     * @param array $message
     */
    public function setFlashdata($key, $message);
}
