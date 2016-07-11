<?php

namespace Chevron\Kernel\Router\Interfaces;
/**
 * the signature for our router
 *
 * @package Chevron\Kernel
 * @author Jon Henderson
 */
interface RouterInterface {

	/**
	 * get a Route based on the given $path
	 * @param string $path The path to parse
	 * @return \Chevron\Kernel\Router\Route
	 */
	public function match($path);

	/**
	 * create a link from the raw components of a route
	 * @param string $controller The dispatchable class
	 * @param string $action The method of the class
	 * @param string $format The format of the resonse
	 * @param array $options The key => val to use in the query string
	 * @return string
	 */
	public function generate($controller, $action = null, $format = null, array $options = []);

}
