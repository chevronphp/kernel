<?php

namespace Chevron\Kernel\Router;
/**
 * an object representing a parsed route
 *
 * @package Chevron\Kernel
 * @author Jon Henderson
 */
class Route implements RouteInterface{

	const CONTROLLER_KEY = "controller";

	const ACTION_KEY     = "action";

	const FORMAT_KEY     = "format";

	/**
	 * the value to return as the requested controller.
	 *
	 * will represent a full namespace path to a class
	 */
	protected $controller;

	/**
	 * the action method to call on the controller object, once instantiated
	 */
	protected $action;

	/**
	 * the format the response should take
	 */
	protected $format;

	/**
	 * an array of the parsed query string
	 */
	protected $params = [];

	/**
	 * create a Route
	 * @param string $controller the value to return as the requested controller.
	 * @param string $action the action method to call on the controller object, once instantiated
	 * @param string $format the format the response should take
	 * @param array array $params an array of the parsed query string
	 * @return \Chevron\Router\Route
	 */
	function __construct($controller, $action = null, $format = null, array $params = []){
		$this->controller = $controller;

		if($action){
			$this->setAction($action);
		}

		if($format){
			$this->setFormat($format);
		}

		if($params){
			$this->setParams($params);
		}

	}

	/**
	 * get the controller
	 * @return string
	 */
	function getController(){
		return $this->controller;
	}

	/**
	 * get the action
	 * @return string
	 */
	function getAction(){
		return $this->action;
	}

	/**
	 * get the format
	 * @return string
	 */
	function getFormat(){
		return $this->format;
	}

	/**
	 * get the params
	 * @return array
	 */
	function getParams(){
		return $this->params;
	}

	/**
	 * output the route as an array
	 * @return array
	 */
	function toArray(){
		return [
			static::CONTROLLER_KEY => $this->getController(),
			static::ACTION_KEY     => $this->getAction(),
			static::FORMAT_KEY     => $this->getFormat(),
		];
	}

	/**
	 * create a link looking string from the properties of the route
	 */
	function __toString(){

		$route = strtolower(strtr(trim($this->getController(), DIRECTORY_SEPARATOR), "\\", "/")) . "/";

		if($this->action){
			$route .= strtolower($this->getAction());
		}

		if($this->format){
			$route .= "." . strtolower($this->getFormat());
		}

		if($this->params){
			$route .= "?" . http_build_query($this->getParams());
		}

		return ltrim($route, "/");
	}

	/**
	 * add a namespace prefix to the route's link looking string on the off
	 * chance that you're dispatching from a specific namespace
	 * @param string $namespace The prefix for the link
	 */
	function link($namespace = ""){
		$prefix = "";
		if($namespace){
			$prefix = strtolower(trim($namespace, "\\/"));
		}
		$link = ltrim($this->__toString(), "/");
		return ltrim("{$prefix}/{$link}", "/");
	}

	/**
	 * get the action
	 * @param string $action
	 * @return string
	 */
	function setAction($action){
		$this->action = $action;
	}

	/**
	 * get the format
	 * @param string $format
	 * @return string
	 */
	function setFormat($format){
		$this->format = $format;
	}

	/**
	 * get the params
	 * @param array $params
	 * @return array
	 */
	function setParams(array $params){
		$this->params = $params;
	}

}