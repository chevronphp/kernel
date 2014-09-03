<?php

namespace Chevron\Kernel\Dispatcher;

use Chevron\Containers\Interfaces\DiInterface;
use Chevron\Kernel\Router\Interfaces\RouteInterface;
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
	 * set out Di
	 */
	function __construct( DiInterface $di, $namespace = null ){
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
	 * do the dispatching
	 * @return \Chevron\Kernel\Controller\Interfaces\AbstractControllerInterface
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

		return function($method = "") use ($object){

			call_user_func([$object, "init"]);

			if($method){
				$object = [$object, $method];
			}

			return call_user_func($object);
		};

	}

}
