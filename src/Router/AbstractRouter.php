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

	const DEFAULT_ACTION = "index";
	const DEFAULT_FORMAT = "html";

	/**
	 * @var The root namespace to which requests are routed
	 */
	protected $rootNamespace;

	public function __construct($ns = "\\"){
		$this->rootNamespace = $this->trimSlashes($ns);
	}

	/**
	 * trim the slashes from a string
	 * @param string $name The string
	 * @return string
	 */
	protected function trimSlashes($name){
		return trim($name, " /\\");
	}

	/**
	 * check if a class is in the root namespace
	 * @param string $class The fully qualified class name
	 * @return bool
	 */
	protected function isOfNamespace($class){
		return stripos($this->trimSlashes($class), $this->rootNamespace . "\\") === 0;
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

		$method = self::DEFAULT_ACTION;
		$format = self::DEFAULT_FORMAT;
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

	/**
	 * @inheritdoc
	 */
	public function generate($controller, $action = null, $format = null, array $options = []){
		if(is_object($controller)){
			$controller = get_class($controller);
		}

		return $this->generateFromRoute(new Route($controller, $action, $format, $options));
	}

	/**
	 * reverse a Route into it's url
	 * @param Route $route
	 * @return string
	 */
	protected function generateFromRoute(Interfaces\RouteInterface $route){

		$controller = $route->getController();


		if(is_object($controller)){
			drop($route);
		}

		if($this->isOfNamespace($controller)){
			$controller = substr($controller, strlen($this->rootNamespace));
		}

		$prefix = strtolower(strtr(trim($controller, DIRECTORY_SEPARATOR), "\\", "/"));

		$action = strtolower($route->getAction() ?: self::DEFAULT_ACTION);

		$format = strtolower($route->getFormat() ?: self::DEFAULT_FORMAT);

		$query = "";
		if($route->getParams()){
			$query = http_build_query($route->getParams());
		}

		return rtrim(sprintf("%s/%s.%s?%s", $prefix, $action, $format, $query), " ?./");
	}

}




