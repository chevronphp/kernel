<?php

namespace Chevron\Kernel\Controllers;

use \Chevron\Kernel\Response\HeadersInterface;

class ErrorController extends BaseController {

	protected $response;

	function init(){
		// init something fancy
		$this->response = $this->di->get("response");
	}

	/**
	 * handle errors
	 *
	 * 404 -- "404 means \"00PS\" in H@X0R.\n\n"
	 * 500 -- "OH NOES!! Something very wrong is happening.\n\n"
	 */
	function __invoke($code = 404, \Exception $e = null){
		$this->setErrorHeaders(intval($code));
		if($e){ $this->logException($e); }
		return function(){  };
	}

	protected function setErrorHeaders($status){
		if($this->response InstanceOf HeadersInterface){
			$response->setContentType($this->route->getFormat());
			$response->setStatusCode($status);
		}
	}
}