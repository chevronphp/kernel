<?php

namespace Chevron\Kernel\Router;
/**
 * A very simple and quite opinionated routing system
 *
 * URL matching assumes the following formats:
 *
 * /path/to/controller/action?query=string&params=true
 * /path/to/controller/?query=string&params=true
 * /path/to/controller/action.format
 * /path/to/controller/action
 * /path/to/controller/
 * /path/to/controller?query=params
 *
 * URL matching assumes the following defaults:
 *
 * action = index
 * format = html
 *
 * @package Chevron\Kernel
 * @author Jon Henderson
 */
class BasicRouter extends AbstractRouter implements Interfaces\RouterInterface {

	/**
	 * public access to get a populated Route
	 *
	 * @param string $path A string representing the path to be parsed -- $_SERVER[REQUEST_URI]
	 * @return Route
	 */
	function match($path){
		list($controller, $action, $format, $parameters) = $this->parseRequest($path);
		return new Route($controller, $action, $format, $parameters);
	}

}
