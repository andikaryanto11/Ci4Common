<?php

namespace Ci4Common\Services;

use Ci4Common\Libraries\DbtransLib;

class DbTransService implements DbTransServiceInterface
{
    /**
     * @inheritDoc
     *
     * @return void
     */
    public function beginTransaction()
    {
        DbtransLib::beginTransaction();
    }

    /**
     * @inheritDoc
     *
     * @return void
     */
    public function commit()
    {
        DbtransLib::commit();
    }

    /**
     * @inheritDoc
     *
     * @return void
     */
    public function rollback()
    {
        DbtransLib::rollback();
    }
}
