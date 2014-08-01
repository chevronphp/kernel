<?php

namespace \Chevron\Kernel\Controller\Stock;

use \Chevron\Kernel\Controller\AbstractController;
use \Chevron\Kernel\Response\Interfaces\HeadersInterface;
/**
 * an example error controller
 * @package Chevron\Kernel
 */
class ErrorController extends AbstractController {

	/**
	 * do our action
	 */
	function __invoke(){
		$action = $this->getRoute()->getAction();
		if(method_exists($this, $action)){
			return $this->$action();
		}else{
			return $this->_500();
		}
	}

	/**
	 * handle the 404 error
	 */
	function _404(){
		$response = $this->di->get("response");

		if($response InstanceOf HeadersInterface){
			$response->detectContentTypeByExtension($this->getRoute()->getFormat());
			$response->setStatusCode(404);
		}

		return function(){
			echo "404 means \"00PS\" in H@X0R.";
		};
	}

	/**
	 * handle the 500 error
	 */
	function _500(){
		$response = $this->di->get("response");

		if($response InstanceOf HeadersInterface){
			$response->detectContentTypeByExtension($this->getRoute()->getFormat());
			$response->setStatusCode(500);
		}

		return function(){
			echo "@#$% Oh Noes!!";
		};
	}

}