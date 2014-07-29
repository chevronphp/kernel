<?php

namespace Chevron\Kernel\Router;
/**
 * A very simple and quite opinionated routing system
 *
 * @package Chevron\Router
 * @author Jon Henderson
 */
class WebRouter extends AbstractRouter implements Interfaces\RouterInterface {

	/**
	 * public access to get a populated Route
	 *
	 * @param string $path A string representing the path to be parsed -- $_SERVER[REQUEST_URI]
	 * @return \Chevron\Router\Route
	 */
	function match($path, array $params = []){
		list($controller, $action, $format, $parameters) = $this->parseRequestUri($path);
		return new Route($controller, $action, $format, $parameters);
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
		$path = pathinfo($url["path"]);

		$controller = "";
		if(isset($path["dirname"])){
			$controller = strtr(ucwords(strtr(ltrim($path["dirname"], " /"), "/", " ")), " ", "\\");
			// $controller = "{$this->namespace}/{$controller}";
		}

		$action = "index";
		if(isset($path["filename"])){
			$action = $path["filename"] ?: $action;
		}

		$format = "html";
		if(isset($path["extension"])){
			$format = $path["extension"] ?: $format;
		}

		$query = [];
		if(isset($url["query"])){
			parse_str($url["query"], $query);
		}

		return [$controller, $action, $format, $query];
	}

	// protected $preHooks  = [];

	// protected function preHooks($path){
	// 	if(!$this->preHooks){ return; };
	// 	foreach($this->preHooks as $hook){
	// 		$return = call_user_func($hook, $path);
	// 		if($return InstanceOf Interfaces\RouteInterface){
	// 			return $return;
	// 		}
	// 	}
	// }

	// function preHook(callable $func){
	// 	$this->preHooks[] = $func;
	// }

	// protected $postHooks = [];

	// protected function postHooks($route){
	// 	if(!$this->postHooks){ return; };
	// 	foreach($this->postHooks as $hook){
	// 		$return = call_user_func($hook, $route);
	// 		if($return InstanceOf Interfaces\RouteInterface){
	// 			return $return;
	// 		}
	// 	}
	// }

	// function postHook(callable $func){
	// 	$this->postHooks[] = $func;
	// }

}