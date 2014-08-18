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

		$actions = [
			$this->getAutoInitFunc(),
			$this->getRoute()->getAction(),
		];

		foreach($actions as $action){
			if(method_exists($this, $action)){
				$return = $this->$action();
				if(is_callable($return)){
					return $return;
				}
			}
		}

		// if nothing returned and the requested action wasn't found, barf
		if(!method_exists($this, $this->getRoute()->getAction())){
			throw new Exceptions\ActionNotFoundException;
		}
	}

}