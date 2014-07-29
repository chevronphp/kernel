<?php

namespace Chevron\Kernel\Dispatcher;

use \Chevron\Containers\Interfaces\DiInterface;
use \Chevron\Kernel\Router\Interfaces\RouteInterface;

use \Exception;

class Dispatcher {

	protected $di;

	function __constructor( DiInterface $di ){
		$this->di = $di;
	}

	function dispatch( $namespace, RouteInterface $route ){

		$controller = sprintf("\\%s\\%s",
			trim($namespace, "\\"),
			trim($route->getController(), "\\")
		);

		if(!class_exists($controller)){
			throw new Exceptions\ControllerNotFoundException;
		}

		return new $controller($this->di, $route);

	}

}
