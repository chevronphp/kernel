<?php

namespace Chevron\Kernel\Controller\Stock;

use \Chevron\Kernel\Controller\BaseController;
use \Chevron\Kernel\Response\Interfaces\HeadersInterface;
use \Chevron\Kernel\Controller\Exceptions;
/**
 * an example error controller
 * @package Chevron\Kernel
 */
class ErrorController extends BaseController {

	/**
	 * do our action
	 */
	function __invoke(){
		try{
			return parent::__invoke();
		}catch(Exceptions\ActionNotFoundException $e){
			return $this->_500();
		}
	}

	protected function setErrorHeaders($status){
		$response = $this->di->get("response");
		if($response InstanceOf HeadersInterface){
			$response->setContentType($this->getRoute()->getFormat());
			$response->setStatusCode($status);
		}
	}

	/**
	 * handle the 404 error
	 */
	function _404(){
		$this->setErrorHeaders(404);
		return function(){
			echo "404 means \"00PS\" in H@X0R.";
		};
	}

	/**
	 * handle the 500 error
	 */
	function _500(){
		$this->setErrorHeaders(500);
		return function(){
			echo "@#$% Oh Noes!!";
		};
	}

}