<?php

namespace Ci4Common\Services;

use Ci4Orm\Eloquent;

class EloquentManagerService implements EloquentManagerServiceInterface
{
    /**
     * @var
     */
    protected Eloquent $eloquentInstance;

    /**
     * @inheritdoc
     */
    public function eloquent(Eloquent $eloquentInstance)
    {
        $this->eloquentInstance = $eloquentInstance;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function validate()
    {
        $this->eloquentInstance->validate();
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function persist()
    {
        return $this->eloquentInstance->save();
    }


    /**
     * @inheritdoc
     */
    public function delete()
    {
        return $this->eloquentInstance->delete();
    }
}
