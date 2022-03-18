<?php

namespace Ci4Common\Services;

use Ci4Common\Libraries\SessionLib;

interface ViewCollectionServiceInterface
{
    /**
     * Add view to collection
     * @param string
     * @return ViewCollectionServiceInterface
     */
    public function addView(string $view);

   /**
    * Get all views
    * @return array
    */
    public function getViews();
}
