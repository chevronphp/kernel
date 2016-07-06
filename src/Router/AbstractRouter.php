<?php

namespace Chevron\Kernel\Router;
/**
 * A very simple and quite opinionated routing system, this is here ONLY to tweak
 * inheritence later on if I get the urge.
 *
 * @package Chevron\Kernel
 * @author Jon Henderson
 */
abstract class AbstractRouter {

	/**
	 * the default action
	 */
	protected $default_action = "index";

	/**
	 * set the default action
	 */
	function setDefaultAction($action){
		$this->default_action = $action;
	}

	/**
	 * the default format
	 */
	protected $default_format = "html";

	/**
	 * set the default format
	 */
	function setDefaultFormat($format){
		$this->default_format = $format;
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
	 * @note ^([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)(?:\.([\w]*))?(?:\?(.*))?
	 *
	 * @param string $path A string representing the path to be parsed -- $_SERVER[REQUEST_URI]
	 * @return array
	 */
	protected function parseRequest($path){
		$url  = parse_url($path);

		$parts = explode("/", $url["path"]);
		$action = array_pop($parts); // methods are lowercase
		array_walk($parts, function(&$v){ //, $k
			$v = ucwords($v);
		});
		$class = implode("\\", $parts);

		$controller = "";
		if($class){
			$controller = $class;
		}

		$method = $this->default_action;
		$format = $this->default_format;
		if($action){
			$method = $action;
			if(($pos = strpos($action, ".")) !== false){
				$method = substr($action, 0, $pos);
				$format = substr($action, ++$pos);
			}
		}

		$query = [];
		if(isset($url["query"])){
			parse_str($url["query"], $query);
		}

		return [$controller, $method, $format, $query];
	}

}
