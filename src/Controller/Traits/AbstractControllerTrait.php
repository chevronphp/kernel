<?php

namespace Chevron\Kernel\Controller\Traits;

use \Chevron\Containers\Interfaces\DiInterface;
use \Chevron\Kernel\Router\Interfaces\RouteInterface;

trait AbstractControllerTrait {

	protected $di;

	protected $route;

	function __construct(DiInterface $di, RouteInterface $route){
		$this->di    = $di;
		$this->route = $route;
	}

	function getDi(){
		return $this->di;
	}

	function getRoute(){
		return $this->route;
	}

	abstract function __invoke();

}