<?php

namespace Ci4Common\Services;

use Ci4Common\Libraries\SessionLib;
use Ci4Common\Libraries\ViewCollectionLib;

class ViewCollectionService implements ViewCollectionServiceInterface
{
    /**
     * @var ViewCollectionLib $viewCollection
     */
    protected ViewCollectionLib $viewCollection;

    /**
     * @param ViewCollectionLib $viewCollection
     */
    public function __construct(ViewCollectionLib $viewCollection)
    {
        $this->viewCollection = $viewCollection;
    }

    /**
     * @inheritdoc
     */
    public function addView(string $view)
    {
        $this->viewCollection->addView($view);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getViews()
    {
        return $this->viewCollection->getViews();
    }
}
