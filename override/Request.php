<?php

namespace App\Override;

use App\Consts\MenusConst;
use Ci4Common\Override\Request as OverrideRequest;

class Request extends OverrideRequest
{
    /**
     * Check if a user has permission to open the page
     *
     * @param string $menu
     * @param string $role
     * @return boolean
     */
    public function isPermited($menu, $role)
    {
        $user = $this->getUser();

        if (empty($user)) {
            return false;
        }

        // command this block of code if you use multiple users and roles
        if (! is_null($user->getMgroupuser())) {
            // For Canvasser only
            if ($menu === MenusConst::MSHOP || $menu === MenusConst::THISTORYFEE  || $menu === MenusConst::MPRODUCT) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }
}
