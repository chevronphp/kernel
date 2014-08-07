<?php

namespace Chevron\Kernel\ControllerTests;

use \Chevron\Kernel\Controller\BaseController;

class TestBaseController extends BaseController {}

class BaseControllerTest extends \PHPUnit_Framework_TestCase {

	function getTestDi(){
		return $this->getMock("\\Chevron\\Containers\\Interfaces\\DiInterface");
	}

	function getTestRoute(){
		$route = $this->getMock("\\Chevron\\Kernel\\Router\\Interfaces\\RouteInterface");

		$route->method("getController")
			  ->willReturn('\\Chevron\\Kernel\\ControllerTests\\TestBaseController');

		$route->method("getAction")
			  ->willReturn('ActionThings');

		$route->method("getFormat")
			  ->willReturn('html');

		$route->method("getParams")
			  ->willReturn([]);

		return $route;

	}

	/**
	 * @expectedException \Chevron\Kernel\Controller\Exceptions\ActionNotFoundException
	 */
	function test___construct(){
		$di    = $this->getTestDi();
		$route = $this->getTestRoute();

		$controller = new TestBaseController($di, $route);

		$view = $controller();
	}

}