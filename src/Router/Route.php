<?php

namespace Chevron\Kernel\Router;
/**
 * an object representing a parsed route
 *
 * @package Chevron\Kernel
 * @author Jon Henderson
 */
class Route implements Interfaces\RouteInterface{

	const DEFAULT_CONTROLLER = "index";
	const CONTROLLER_KEY     = "controller";
	const ACTION_KEY         = "action";
	const FORMAT_KEY         = "format";
	const PARAMS_KEY         = "query";

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
	public function __construct($controller, $action = null, $format = null, array $params = []){
		$this->controller = $controller ?: self::DEFAULT_CONTROLLER;
		$this->setAction($action);
		$this->setFormat($format);
		$this->setParams($params);
	}

	/**
	 * get the controller
	 * @return string
	 */
	public function getController(){
		return $this->controller;
	}

	/**
	 * get the action
	 * @return string
	 */
	public function getAction(){
		return $this->action;
	}

	/**
	 * get the format
	 * @return string
	 */
	public function getFormat(){
		return $this->format;
	}

	/**
	 * get the params
	 * @return array
	 */
	public function getParams(){
		return $this->params;
	}

	/**
	 * get the action
	 * @param string $action
	 * @return string
	 */
	public function setAction($action){
		$this->action = $action;
	}

	/**
	 * get the format
	 * @param string $format
	 * @return string
	 */
	public function setFormat($format){
		$this->format = $format;
	}

	/**
	 * get the params
	 * @param array $params
	 * @return array
	 */
	public function setParams(array $params){
		$this->params = $params;
	}

	/**
	 * get a unique 8 char hash of the request
	 */
	public function getHash(){
		return substr(sha1(json_encode($this->toArray())), 0, 8);
	}

	/**
	 * output the route as an array
	 * @return array
	 */
	public function toArray(){
		return [
			static::CONTROLLER_KEY => $this->getController(),
			static::ACTION_KEY     => $this->getAction(),
			static::FORMAT_KEY     => $this->getFormat(),
			static::PARAMS_KEY     => $this->getParams(),
		];
	}

}
