<?php

namespace Chevron\Kernel\Controller\Traits;

trait DiAwareTrait {

	/**
	 * hold the Di
	 */
	protected $di;

	/**
	 * get the Di
	 * @return \Chevron\Containers\Interfaces\DiInterface
	 */
	function getDi(){
		return $this->di;
	}

	/**
	 * set the Di
	 * @return \Chevron\Containers\Interfaces\DiInterface
	 */
	function setDi($di){
		$this->di = $di;
	}

}