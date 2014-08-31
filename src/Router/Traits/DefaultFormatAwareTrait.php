<?php

namespace Chevron\Kernel\Router\Traits;

trait DefaultFormatAwareTrait {

	/**
	 * the default format
	 */
	protected $default_format = "html";

	/**
	 * set the default format
	 */
	function setDefaultFormat($format){
		$this->default_format = $format;
	}

}