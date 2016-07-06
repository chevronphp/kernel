<?php

namespace Chevron\Kernel\Dispatcher;

use Chevron\Kernel\Router\Interfaces\RouteInterface;
use Chevron\Kernel\Dispatcher\Interfaces\DispatchableInterface;
use Chevron\Kernel\Dispatcher\Interfaces\DispatchableInitializationInterface;
/**
 * our dispatcher is very simple
 * @package Chevron\Kernel
 */
class Dispatcher implements Interfaces\DispatcherInterface {


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
	public function __construct( $di, $namespace = null ){
		$this->di = $di;
		$this->namespace = $namespace;
	}

	/**
	 * set the root namespace from which to dispatch
	 * @param string $namespace The namespace
	 * @return void
	 */
	public function setNamespace($namespace){
		$this->namespace = $namespace;
	}

	/**
	 * Do the dispatching. The resulting closure calls init(), and __invoke(). If a
	 * method name is passed at call time, it supercedes __invoke()
	 * @return \Closure
	 */
	public function dispatch( RouteInterface $route ){

		$fqnsc = "\\";
		if($this->namespace){
			$fqnsc .= trim($this->namespace, "\\");
			$fqnsc .= "\\";
		}
		$fqnsc .= trim($route->getController(), "\\");

		if(!class_exists($fqnsc)){
			throw new \DomainException("Class not found: {$fqnsc}; via {$route}", 500);
		}

		$instance = new \ReflectionClass($fqnsc);

		if(!$instance->implementsInterface(DispatchableInterface::class)){
			throw new \DomainException("Class missing interface: {$fqnsc}; via {$route}", 500);
		}

		$shouldInit = false;
		if($instance->implementsInterface(DispatchableInitializationInterface::class)){
			$shouldInit = true;
		}

		$obj = $instance->newInstanceArgs([$this->di, $route]);

		return function($method = "", array $args = []) use ($obj, $route, $shouldInit){

			if($shouldInit){
				call_user_func_array([$obj, DispatchableInitializationInterface::INIT], [$method]);
			}

			if($method){
				if(!method_exists($obj, $method)){
					throw new \InvalidArgumentException("Method '{$method}' not found on ".get_class($obj)."; via {$route}", 404);
				}
				$obj = [$obj, $method];
			}

			return call_user_func_array($obj, $args);
		};

	}
}
