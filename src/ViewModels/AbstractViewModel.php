<?php

namespace Ci4Common\ViewModels;

use Ci4Orm\Entities\EntityList;
use Ci4Orm\Interfaces\IEntity;

abstract class AbstractViewModel
{
    /**
     * @var bool $autoAddResource;
     */
    protected $isAutoAddResource = true;

    protected $entity;
    /**
     * @param IEntity $entity
     */
    public function __construct(IEntity $entity)
    {
        $this->entity = $entity;
    }

    /**
     * Convert instance to array add auto add resource available
     */
    public function finalArray()
    {
        $array = $this->toArray();
        if ($this->getIsAutoAddResource()) {
            $this->addResource($array);
        }
        return $array;
    }

    /**
     * Convert instance to array
     */
    abstract public function toArray();

    /**
     * Add resource to view model
     */
    abstract public function addResource(array &$element);

    /**
     *  set auto add Resource
     */
    public function setIsAutoAddResource(bool $isAutoAddResource)
    {
        $this->isAutoAddResource = $isAutoAddResource;
        return $this;
    }

    /**
     * if set true then view model will auto add available resource you define
     */
    public function getIsAutoAddResource()
    {
        return $this->isAutoAddResource;
    }
}
