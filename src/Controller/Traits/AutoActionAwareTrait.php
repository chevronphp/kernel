<?php

namespace Chevron\Kernel\Controller\Traits;

trait AutoActionAwareTrait {

	protected $autoInitFunc = "init";

	function setAutoInitFunc($func){
		$this->autoInitFunc = $func;
	}

	function getAutoInitFunc(){
		return $this->autoInitFunc;
	}

}