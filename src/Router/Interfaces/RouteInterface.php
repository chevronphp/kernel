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
	public function getController();

	/**
	 * get the action
	 * @return string
	 */
	public function getAction();

	/**
	 * get the format
	 * @return string
	 */
	public function getFormat();

	/**
	 * get the params
	 * @return array
	 */
	public function getParams();

}
