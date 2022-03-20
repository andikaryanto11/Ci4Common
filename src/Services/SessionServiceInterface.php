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
     * Set Session By Key
     *
     * @param string $key
     * @param mixed $key
     * @return array
     */
    public function set($key, $value);

    /**
     * Remove Session By Key
     *
     * @param string $key
     * @return array
     */
    public function remove($key);

    /**
     * Set Flash Session By Key
     *
     * @param string $key
     * @param array $message
     */
    public function setFlashdata($key, $message);
}
