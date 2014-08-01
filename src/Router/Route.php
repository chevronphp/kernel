<?php

namespace Chevron\Kernel\Router;
/**
 * an object representing a parsed route
 *
 * @package Chevron\Kernel
 * @author Jon Henderson
 */
class Route implements Interfaces\RouteInterface{

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
			$this->action = $action;
		}

		if($format){
			$this->format = $format;
		}

		if($params){
			$this->params = $params;
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


		return $route;
	}

}