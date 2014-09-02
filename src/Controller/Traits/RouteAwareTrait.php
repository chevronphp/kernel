<?php

namespace Chevron\Kernel\Controller\Traits;

trait RouteAwareTrait {

	/**
	 * hold the route for this controller
	 */
	protected $route;

	/**
	 * get the route
	 * @return \Chevron\Kernel\Router\Interfaces\RouteInterface
	 */
	function getRoute(){
		return $this->route;
	}

	/**
	 * set the route
	 * @return \Chevron\Kernel\Router\Interfaces\RouteInterface
	 */
	function setRoute($route){
		$this->route = $route;
	}

}