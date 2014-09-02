<?php

namespace Chevron\Kernel\Dispatcher;

/**
 * our dispatcher is very simple
 * @package Chevron\Kernel
 */
class Dispatcher {

	/**
	 * hold our Di
	 */
	protected $defaultPayload = [];

	/**
	 * set out Di
	 */
	function __construct( array $defaultPayload = [] ){
		$this->defaultPayload = $defaultPayload;
	}

	/**
	 * do the dispatching
	 * @return \Chevron\Kernel\Controller\Interfaces\AbstractControllerInterface
	 */
	function dispatch( $namespace, $controller, array $instanceArgs = [] ){

		$fqnsc = "\\";
		$fqnsc .= trim($namespace, "\\");
		$fqnsc .= "\\";
		$fqnsc .= trim($controller, "\\");

		if(!class_exists($fqnsc)){
			throw new Exceptions\ControllerNotFoundException;
		}

		$instance = new \ReflectionClass($fqnsc);
		$instanceArgs = $this->defaultPayload + $instanceArgs;

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
