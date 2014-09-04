<?php

namespace Chevron\Kernel\Router;

trait DefaultActionAwareTrait {

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

}