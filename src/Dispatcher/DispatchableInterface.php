<?php

namespace Chevron\Kernel\Dispatcher;

use Chevron\Kernel\Router\RouteInterface;

/**
 * our dispatcher is very simple
 * @package Chevron\Kernel
 */
interface DispatchableInterface {

	/**
	 * dispatchable objects take a Di and the current Route
	 * @param DiInterface $di The Di
	 * @param RouteInterface $route The Route
	 * @return void
	 */
	function __construct( $di, $route );

	/**
	 * a second setup method that prepares object state before invokation
	 * @return void
	 */
	function init();

	/**
	 * make our object dispatchable
	 * @return mixed
	 */
	function __invoke();

}
