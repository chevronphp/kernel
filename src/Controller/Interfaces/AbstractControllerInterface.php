<?php

namespace Chevron\Kernel\Controller\Interfaces;

use \Chevron\Containers\Interfaces\DiInterface;
use \Chevron\Kernel\Router\Interfaces\RouteInterface;
/**
 * establishes the signature for controllers
 * @package Chevron\Kernel
 */
interface AbstractControllerInterface {

	/**
	 * controllers should take a Di and a Route
	 */
	function __construct(DiInterface $di, RouteInterface $route);

	/**
	 * controllers should be invokable
	 */
	function __invoke();

}