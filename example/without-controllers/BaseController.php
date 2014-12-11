<?php

namespace Example;

use Chevron\Kernel\Dispatcher\DispatchableInterface;

abstract class BaseController implements DispatchableInterface {

	protected $di, $route;

	function __construct( $di, $route ){
		$this->di = $di;
		$this->route = $route;
	}

	abstract function init();

	function __invoke(){
		$action = $this->route->getAction();
		if(method_exists($this, $action)){
			return call_user_func([$this, $action]);
		}
		throw new ActionNotFoundException;
	}

}