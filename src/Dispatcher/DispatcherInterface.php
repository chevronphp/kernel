<?php

namespace Chevron\Kernel\Dispatcher;
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
	 * @return \Chevron\Kernel\Router\Route
	 */
	function dispatch($path);

}