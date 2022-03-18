<?php

namespace Ci4Common\Services;

use App\Eloquents\M_shops;

interface DbTransServiceInterface
{
    /**
     * Begin Transaction
     *
     */
    public function beginTransaction();

    /**
     * Commit Transactoion
     *
     */
    public function commit();

    /**
     * Rollback Transactoion
     *
     */
    public function rollback();
}
