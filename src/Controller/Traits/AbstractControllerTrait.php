<?php

namespace Chevron\Kernel\Controller\Traits;

use \Chevron\Containers\Interfaces\DiInterface;
use \Chevron\Kernel\Router\Interfaces\RouteInterface;
/**
 * establishes the base functionality for a controller excluding the __invoke()
 * @package Chevron\Kernel
 */
trait AbstractControllerTrait {

	use AutoMethodAwareTrait;
	use DiAwareTrait;
	use RouteAwareTrait;

	/**
	 * set the Di and Route for this controller
	 */
	function __construct(DiInterface $di, RouteInterface $route){
		$this->di    = $di;
		$this->route = $route;
	}

	/**
	 * force children to define functionality
	 */
	abstract function __invoke();

}