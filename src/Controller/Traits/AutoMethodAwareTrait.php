<?php

namespace Chevron\Kernel\Controller\Traits;

trait AutoMethodAwareTrait {

	protected $autoMethodFunc = "init";

	function setAutoMethodFunc($func){
		$this->autoMethodFunc = $func;
	}

	function getAutoMethodFunc(){
		return $this->autoMethodFunc;
	}

}