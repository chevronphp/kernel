<?php

namespace Chevron\Kernel\Dispatcher\Traits;

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
