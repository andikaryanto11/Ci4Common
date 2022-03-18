<?php

namespace Ci4Common\Services;

use App\Exceptions\EloquentException;
use CodeIgniter\HTTP\Header;

interface RequestServiceInterface
{
      /**
     * Get body value
     *
     * @return object|null
     */
    public function getJson();

    /**
     * Get parameter value
     *
     * @return object|null
     */
    public function getGet();

    /**
     * Post body value
     *
     * @return object|null
     */
    public function getPost();
}
