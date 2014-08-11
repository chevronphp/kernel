<?php

namespace Chevron\Kernel\Controller\Stock;

use \Chevron\Kernel\Controller\AbstractController;
/**
 * an example controller
 * @package Chevron\Kernel
 */
class FirstController extends AbstractController {

	/**
	 * do our action
	 */
	function __invoke(){
		$action = $this->getRoute()->getAction();
		return function(){
			echo "{$action}";
		};
	}

}