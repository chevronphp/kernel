<?php

namespace Chevron\Kernel\Router\Interfaces;

interface RouteInterface {

	/**
	 * get the controller
	 * @return string
	 */
	function getController();

	/**
	 * get the action
	 * @return string
	 */
	function getAction();

	/**
	 * get the format
	 * @return string
	 */
	function getFormat();

	/**
	 * get the params
	 * @return array
	 */
	function getParams();

}