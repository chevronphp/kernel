<?php

namespace Chevron\Kernel\Router;
/**
 * A very simple and quite opinionated routing system
 *
 * @package Chevron\Kernel
 * @author Jon Henderson
 */
class CliRouter extends AbstractRouter implements RouterInterface {

	/**
	 * public access to get a populated Route
	 *
	 * @param string $path A string representing the path to be parsed -- $_SERVER[REQUEST_URI]
	 * @return Route
	 */
	function match($path, array $params = []){
		list($controller, $action, $format, $query) = $this->parseRequest($path);
		// $format and $query are ignored in the CLI
		return new Route($controller, $action, null, $params);
	}

}