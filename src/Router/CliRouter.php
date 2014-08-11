<?php

namespace Chevron\Kernel\Router;
/**
 * A very simple and quite opinionated routing system
 *
 * @package Chevron\Kernel
 * @author Jon Henderson
 */
class CliRouter extends AbstractRouter implements Interfaces\RouterInterface {

	use Traits\DefaultActionFormatAwareTrait;

	/**
	 * public access to get a populated Route
	 *
	 * @param string $path A string representing the path to be parsed -- $_SERVER[REQUEST_URI]
	 * @return Route
	 */
	function match($path, array $params){
		list($controller, $action) = $this->parseRequestUri($path);
		return new Route($controller, $action, null, $params);
	}

	/**
	 * take the $_SERVER[REQUEST_URI] and parse it into a path, a file, and an extension
	 * along with an array representing the query string. Everything after the domain
	 * is assumed to be a Name\Space\Controller::action()
	 *
	 * domain.com/users/profiles/edit.html?id=15 should translate to Users\Profiles::edit()
	 *
	 * The router pays no mind to IF the class exists or should be called
	 *
	 * @param string $path A string representing the path to be parsed -- $_SERVER[REQUEST_URI]
	 * @return array
	 */
	protected function parseRequestUri($path){
		$url  = parse_url($path);

		$parts = explode("/", $url["path"]);
		$action = array_pop($parts); // methods are lowercase
		array_walk($parts, function(&$v, $k){
			$v = ucwords($v);
		});
		$class = implode("\\", $parts);

		$controller = "";
		if($class){
			$controller = $class;
		}

		$method = $this->default_action;
		// $format = $this->default_format;
		if($action){
			$method = $action;
			if(($pos = strpos($action, ".")) !== false){
				$method = substr($action, 0, $pos);
				// $format = substr($action, ++$pos);
			}
		}

		return [$controller, $method];

	}

}