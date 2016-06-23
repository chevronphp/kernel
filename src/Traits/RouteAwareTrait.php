<?php

namespace Chevron\Kernel\Traits;

trait RouteAwareTrait {

	protected $route;

	/**
	 *
	 */
	public function setRoute($route){
		$this->route = $route;
	}

	public function getRoute(){
		return $this->route;
	}

}
