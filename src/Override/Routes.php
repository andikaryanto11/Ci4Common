<?php

namespace Ci4Common\Override;

use Ci4Common\Libraries\RedirectLib;
use Ci4Common\Responses\ResponseInterface;
use Ci4Common\Services\ViewCollectionServiceInterface;
use CodeIgniter\Router\RouteCollection;
use CodeIgniter\Router\RouteCollectionInterface;
use Config\Services;

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

	/**
	 *
	 * @param string $method
	 * @param string $from
	 * @param string $controllerName
	 * @param array|null $options
	 * @return RouteCollectionInterface
	 */
	private function doRoute(string $method, string $from, $controllerName, array $options = null) : RouteCollectionInterface
	{
		if(!is_callable($controllerName)){
			$containerBuilder = Services::container(false);
			$routes = $this;
			$controllerNameAndFunction = explode(':', $controllerName);
			if(count($controllerNameAndFunction) == 2){
				$strController = $controllerNameAndFunction[0];
				$fn = $controllerNameAndFunction[1];
				$request = service('request');
				$callback = function (...$parameters) use ($containerBuilder, $strController, $fn, $request, $routes) {
					return $routes->willReturn($containerBuilder->get($strController)->$fn($request, ...$parameters));
				};
			} else {
				$callback  = $controllerName;
			}
		} else {
			$callback  = $controllerName;
		}
		return parent::$method($from, $callback, $options);
	}

	/**
	 * @param string $from
	 * @param string $controllerName
	 * @param array|null $options
	 * @return RouteCollectionInterface
	 */
	public function get(string $from, $to, array $options = null): RouteCollectionInterface
	{
		return $this->doRoute('get', $from, $to, $options);

	}

	/**
	 * @param string $from
	 * @param string $controllerName
	 * @param array|null $options
	 * @return RouteCollectionInterface
	 */
	public function post(string $from, $to, array $options = null): RouteCollectionInterface
	{
		return $this->doRoute('post', $from, $to, $options);

	}


	/**
	 * @param string $from
	 * @param string $controllerName
	 * @param array|null $options
	 * @return RouteCollectionInterface
	 */
	public function put(string $from, $to, array $options = null): RouteCollectionInterface
	{
		return $this->doRoute('put', $from, $to, $options);

	}

	/**
	 * @param string $from
	 * @param string $controllerName
	 * @param array|null $options
	 * @return RouteCollectionInterface
	 */
	public function delete(string $from, $to, array $options = null): RouteCollectionInterface
	{
		return $this->doRoute('delete', $from, $to, $options);

	}
}
