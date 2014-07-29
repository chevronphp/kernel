<?php

namespace Chevron\Kernel\Router\Interfaces;
/**
 * our signature for a Route
 *
 * @package Chevron\Kernel
 * @author Jon Henderson
 */
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