<?php

namespace Chevron\Kernel\Dispatcher;

use \Chevron\Containers\Interfaces\DiInterface;
use \Chevron\Kernel\Router\Interfaces\RouteInterface;
/**
 * our dispatcher is very simple
 * @package Chevron\Kernel
 */
class Dispatcher {

	/**
	 * hold our Di
	 */
	protected $di;

	/**
	 * set out Di
	 */
	function __construct( DiInterface $di ){
		$this->di = $di;
	}

	/**
	 * do the dispatching
	 * @return \Chevron\Kernel\Controller\Interfaces\AbstractControllerInterface
	 */
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
