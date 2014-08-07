<?php

namespace Chevron\Kernel\Controller\Traits;

use \Chevron\Kernel\Controller\Exceptions;

/**
 * establishes the base functionality for a controller excluding the __invoke()
 * @package Chevron\Kernel
 */
trait BaseControllerTrait {

	use AbstractControllerTrait;

	/**
	 * by default, assume that the action is a method
	 */
	function __invoke(){
		$action = $this->getRoute()->getAction();
		if(method_exists($this, $action)){
			return $this->$action();
		}else{
			throw new Exceptions\ActionNotFoundException;
		}
	}

}