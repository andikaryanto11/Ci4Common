<?php

namespace Ci4Common\Shared;

use Config\Kernel;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class Container
{
    private ContainerBuilder $containerBuilder;
    public function __construct()
    {
        $this->containerBuilder = new ContainerBuilder();
        $this->loadServices();
    }

	/**
	 * get ContainerBuilder
	 *
	 * @return ContainerBuilder
	 */
	public function getContainerBuilder()
    {
        return $this->containerBuilder;
    }

	/**
	 * Load all services that is registered in App\Kernel
	 *
	 * @return void
	 */
	private function loadServices(){
		$kernel = new Kernel();
		foreach($kernel->services() as $service){
			$asService = require $service;
			$asService($this->containerBuilder);
		}
	}
}
