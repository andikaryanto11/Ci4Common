<?php

namespace Ci4Common\Libraries;

class ViewCollectionLib
{
    /**
     * @var array
     */
    protected $views;

    /**
     * Add view
     *
     * @param string $view
     */
    public function addView(string $view)
    {
        $this->views[] = $view;
    }

    public function getViews()
    {
        return $this->views;
    }
}
