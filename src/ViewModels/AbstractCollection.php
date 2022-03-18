<?php

namespace Ci4Common\ViewModels;

use Ci4Orm\Entities\EntityList;
use Ci4Orm\Interfaces\IEntity;

abstract class AbstractCollection
{
    protected $collection;
    protected $element;
    /**
     * @param array|EntityList $collection
     */
    public function __construct($collection)
    {
        $this->collection = $collection;
    }

    /**
     * Eloquent to View Model
     */
    abstract public function shape(IEntity $entity);

    /**
     * proceed shaping to view model
     */
    public function proceed()
    {
        foreach ($this->collection as $item) {
            $this->shape($item);
        }
        return $this;
    }

    public function finalProcceed()
    {
        return $this->proceed()->getElements();
    }

    /**
     * Add item element
     */
    public function addItem(AbstractViewModel $viewModel)
    {
        $items = $viewModel->toArray();
        $viewModel->addResource($items, $this->collection);
        $this->element[] = $items;
    }

    /**
     * Get elemet
     */
    public function getElements()
    {
        return $this->element;
    }
}
