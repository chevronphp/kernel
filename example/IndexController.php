<?php

namespace Example;

use \Chevron\Kernel\Response\HeadersInterface;

class IndexController extends BaseController {

	protected $response;

	function init(){
		// init something fancy
		$this->response = $this->di->get("response");
	}

	function index(){
		return function(){
			echo "Hello World.\n\n";
		};
	}

	protected function setErrorHeaders($status){
		if($this->response InstanceOf HeadersInterface){
			$response->setContentType($this->route->getFormat());
			$response->setStatusCode($status);
		}
	}

	/**
	 * handle the 404 error
	 */
	function _404(){
		$this->setErrorHeaders(404);
		return function(){
			echo "404 means \"00PS\" in H@X0R.\n\n";
		};
	}

	/**
	 * handle the 404 error
	 */
	function _500(){
		$this->setErrorHeaders(404);
		return function(){
			echo "OH NOES!! Something very wrong is happening.\n\n";
		};
	}

}