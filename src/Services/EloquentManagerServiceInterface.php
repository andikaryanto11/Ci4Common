<?php

namespace Ci4Common\Services;

use Ci4Orm\Eloquent;

interface EloquentManagerServiceInterface
{
    /**
     * Set eloquent instance
     * @param Eloquent $eloquent
     * @return EloquentManagerServiceInterface
     */
    public function eloquent(Eloquent $eloquent);

    /**
     * Validate loquent instance
     * @return EloquentManagerServiceInterface
     */
    public function validate();

    /**
     * Persist
     * @return bool
     */
    public function persist();


    /**
     * Delete
     * @return bool
     */
    public function delete();
}
