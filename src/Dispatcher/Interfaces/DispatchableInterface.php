<?php

namespace Chevron\Kernel\Dispatcher\Interfaces;

use Chevron\Kernel\Router\Interfaces\RouteInterface;

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
	public function __construct( $di, $route );

	/**
	 * make our object dispatchable
	 * @return mixed
	 */
	public function __invoke();

}
