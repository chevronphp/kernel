<?php

namespace Chevron\Kernel\Controller\Traits;

use \Chevron\Containers\Interfaces\DiInterface;
use \Chevron\Kernel\Router\Interfaces\RouteInterface;
/**
 * establishes the base functionality for a controller excluding the __invoke()
 * @package Chevron\Kernel
 */
trait AbstractControllerTrait {

	use AutoActionAwareTrait;

	/**
	 * hold the Di
	 */
	protected $di;

	/**
	 * hold the route for this controller
	 */
	protected $route;

	/**
	 * set the Di and Route for this controller
	 */
	function __construct(DiInterface $di, RouteInterface $route){
		$this->di    = $di;
		$this->route = $route;
	}

	/**
	 * get the Di
	 * @return \Chevron\Containers\Interfaces\DiInterface
	 */
	function getDi(){
		return $this->di;
	}

	/**
	 * get the route
	 * @return \Chevron\Kernel\Router\Interfaces\RouteInterface
	 */
	function getRoute(){
		return $this->route;
	}

	/**
	 * force children to define functionality
	 */
	abstract function __invoke();

}