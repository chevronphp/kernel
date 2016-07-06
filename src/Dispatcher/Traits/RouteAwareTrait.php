<?php

namespace Chevron\Kernel\Dispatcher\Traits;

trait RouteAwareTrait {

	protected $route;

	/**
	 *
	 */
	protected function setRoute($route){
		$this->route = $route;
	}

	protected function getRoute(){
		return $this->route;
	}

}
