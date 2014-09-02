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
	function dispatch( $namespace, RouteInterface $route, array $args = [] ){

		$controller = sprintf("\\%s\\%s",
			trim($namespace, "\\"),
			trim($route->getController(), "\\")
		);

		if(!class_exists($controller)){
			throw new Exceptions\ControllerNotFoundException;
		}

		$instance = new \ReflectionClass($controller);
		$instanceArgs = [$this->di, $route] + $args;

		try{
			return $instance->newInstanceArgs($instanceArgs);
		}catch(\ReflectionException $e){
			try{
				return $instance->newInstance();
			}catch(\ReflectionException $e){
				// return $instance->newInstanceWithoutConstructor();
				$message = "Controllers must have an accessible constructor.";
				throw new Exceptions\InaccessibleConstructorException($message, 0, $e);
			}
		}

		// return new $controller($this->di, $route);

	}

}
