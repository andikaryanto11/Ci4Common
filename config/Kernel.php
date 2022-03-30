<?php

namespace Config;

use App\Repositories\M_userRepository;
use Ci4Common\Config\IKernel;
use Ci4Common\Config\Kernel as ConfigKernel;

class Kernel extends ConfigKernel implements IKernel
{
    /**
     * @inheritDoc
     */
    public function userRepository()
    {
        return M_userRepository::class;
    }

    public function services()
    {
        return [
            ROOTPATH . 'services/controllers.php',
            ROOTPATH . 'services/services.php',
            ROOTPATH . 'services/repositories.php',
            ROOTPATH . 'services/graphql.php'
        ];
    }
}
