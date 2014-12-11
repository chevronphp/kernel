<?php

namespace Chevron\Kernel\Controllers;

use Psr\Log;
use Chevron\Kernel\Dispatcher\DispatchableInterface;

abstract class BaseController implements DispatchableInterface {

	use Log\LoggerAwareTrait;

	protected $di, $route;

	function __construct( $di, $route ){
		$this->di    = $di;
		$this->route = $route;
	}

	abstract function init();

	function __invoke(){
		$action = $this->route->getAction();
		if(method_exists($this, $action)){
			return call_user_func([$this, $action]);
		}
		$this->logException(new ActionNotFoundException);
	}

	protected function logException(\Exception $e){
		if($this->logger InstanceOf Log\LoggerInterface){
			$this->logger->error(get_class($e), [
				"e.type"           => get_class($e),
				"e.message"        => $e->getMessage(),
				"e.code"           => $e->getCode(),
				"e.file"           => $e->getFile(),
				"e.line"           => $e->getLine(),
				"route.controller" => $this->route->getController(),
				"route.action"     => $this->route->getAction(),
				"route.format"     => $this->route->getFormat(),
				"route.params"     => $this->route->getParams(),
				"info.class"       => get_class($this),
			]);
		}
		throw $e;
	}

}