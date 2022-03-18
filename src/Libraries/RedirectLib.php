<?php

namespace Ci4Common\Libraries;

class RedirectLib
{
    private $route;
    private $code = 303;
    private function __constrcut()
    {
    }

    public function setStatusCode(int $code)
    {
        $this->code = $code;
        return $this;
    }

    public static function redirect($route)
    {
        $redirect        = new static();
        $redirect->route = $route;
        return $redirect;
    }

    public function with($data)
    {
        if (! empty($data)) {
            session()->setFlashData([Commonlib::getKey() . 'dataform' => get_object_vars($data)]);
        }
        return $this;
    }

    public function go()
    {
        return redirect()->to(baseUrl($this->route));
    }
}
