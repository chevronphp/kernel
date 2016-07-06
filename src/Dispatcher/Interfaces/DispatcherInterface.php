<?php

namespace Chevron\Kernel\Dispatcher\Interfaces;

use Chevron\Kernel\Router\Interfaces\RouteInterface;

/**
 * the signature for our router
 *
 * @package Chevron\Kernel
 * @author Jon Henderson
 */
interface DispatcherInterface {

	/**
	 * get a Route based on the given $path
	 * @param string $path The path to parse
	 * @return \Closure
	 */
	function dispatch( RouteInterface $route );

}
