<?php

namespace Chevron\Kernel\Router\Traits;

trait DefaultActionFormatAwareTrait {

	/**
	 * the default action
	 */
	protected $default_action = "index";

	/**
	 * the default format
	 */
	protected $default_format = "html";

	/**
	 * set the default action
	 */
	function setDefaultAction($action){
		$this->default_action = $action;
	}

	/**
	 * set the default format
	 */
	function setDefaultFormat($format){
		$this->default_format = $format;
	}

}