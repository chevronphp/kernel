<?php

namespace Chevron\Kernel\Traits;

trait DiAwareTrait {

	protected $di;

	/**
	 *
	 */
	public function setDi($di){
		$this->di = $di;
	}

	public function getDi(){
		return $this->di;
	}

}
