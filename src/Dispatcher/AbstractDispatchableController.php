<?php

namespace Chevron\Kernel\Dispatcher;

use Psr\Log;

abstract class AbstractDispatchableController implements DispatchableInterface {

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
			return call_user_func_array([$this, $action], func_get_args());
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

	/****************************
		EXAMPLE ERROR HANDLING
	****************************/

	// protected $response;

	// function init(){
	// 	// init something fancy
	// 	$this->response = $this->di->get("response");
	// }

	/**
	 * handle errors
	 *
	 * 404 -- "404 means \"00PS\" in H@X0R.\n\n"
	 * 500 -- "OH NOES!! Something very wrong is happening.\n\n"
	 */
	// function __invoke($code = 404, \Exception $e = null){
	// 	$this->setErrorHeaders(intval($code));
	// 	if($e){ $this->logException($e); }
	// 	return function(){  };
	// }

	// protected function setErrorHeaders($status){
	// 	if($this->response InstanceOf HeadersInterface){
	// 		$response->setContentType($this->route->getFormat());
	// 		$response->setStatusCode($status);
	// 	}
	// }

}