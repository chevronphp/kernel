<?php

namespace Chevron\Kernel\Router;
/**
 * an object representing a parsed route
 *
 * @package Chevron\Kernel
 * @author Jon Henderson
 */
class RouteFactory {

	/**
	 * create a Route
	 * @param string $controller the value to return as the requested controller.
	 * @param string $action the action method to call on the controller object, once instantiated
	 * @param string $format the format the response should take
	 * @param array array $params an array of the parsed query string
	 * @return \Chevron\Router\Route
	 */
	public function make($controller, $action = null, $format = null, array $params = []){
		return new Route($controller, $action, $format, $params);
	}

}
