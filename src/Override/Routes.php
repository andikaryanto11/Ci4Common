<?php

namespace Ci4Common\Override;

use Ci4Common\Libraries\RedirectLib;
use Ci4Common\Responses\ResponseInterface;
use Ci4Common\Services\ViewCollectionServiceInterface;
use CodeIgniter\Router\RouteCollection;

class Routes extends RouteCollection
{
    /**
     * Will return what's controller return
     *
     * @param ResponseInterface|ViewCollectionServiceInterface|RedirectLib $controllerReturn
     * @return mixed
     */
    public function willReturn($controllerReturn)
    {

        if ($controllerReturn instanceof ResponseInterface) {
            return $controllerReturn->send();
        }

        if ($controllerReturn instanceof ViewCollectionServiceInterface) {
            foreach ($controllerReturn->getViews() as $view) {
                echo $view;
            }
        }

        if ($controllerReturn instanceof RedirectLib) {
            return $controllerReturn->go();
        }
    }
}
