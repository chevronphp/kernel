<?php

namespace Chevron\Kernel\Dispatcher;

use Chevron\Kernel\Router\RouteInterface;
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
	 * the root namspace from which to dispatch
	 */
	protected $namespace;

	/**
	 * set our Di
	 */
	function __construct( $di, $namespace = null ){
		$this->di = $di;
		$this->namespace = $namespace;
	}

	/**
	 * set the root namespace from which to dispatch
	 * @param string $namespace The namespace
	 * @return void
	 */
	function setNamespace($namespace){
		$this->namespace = $namespace;
	}

	/**
	 * Do the dispatching. The resulting closure calls init(), and __invoke(). If a
	 * method name is passed at call time, it supercedes __invoke()
	 * @return \Closure
	 */
	function dispatch( RouteInterface $route ){

		$fqnsc = "\\";
		if($this->namespace){
			$fqnsc .= trim($this->namespace, "\\");
			$fqnsc .= "\\";
		}
		$fqnsc .= trim($route->getController(), "\\");

		if(!class_exists($fqnsc)){
			throw new ControllerNotFoundException;
		}

		$instance = new \ReflectionClass($fqnsc);

		if(!$instance->implementsInterface(__NAMESPACE__ . "\\DispatchableInterface")){
			throw new NonDispatchableObjectException;
		}

		$object = $instance->newInstance($this->di, $route);

		return function($method = "", array $args = []) use ($object){

			call_user_func([$object, "init"]);

			if($method){
				$object = [$object, $method];
			}

			return call_user_func($object);
		};

	}
}
