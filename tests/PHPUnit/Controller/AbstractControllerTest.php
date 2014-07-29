<?php

namespace Chevron\Kernel\ControllerTests;

use \Chevron\Kernel\Controller\AbstractController;

class TestController extends AbstractController {
	function __invoke(){ /* noop */ }
}

class AbstractControllerTest extends \PHPUnit_Framework_TestCase {

	function getTestDi(){
		return $this->getMock("\\Chevron\\Containers\\Interfaces\\DiInterface");
	}

	function getTestRoute(){
		$route = $this->getMock("\\Chevron\\Kernel\\Router\\Interfaces\\RouteInterface");

		$route->method("getController")
			  ->willReturn('\\Chevron\\Kernel\\ControllerTests\\TestController');

		$route->method("getAction")
			  ->willReturn('ActionThings');

		$route->method("getFormat")
			  ->willReturn('html');

		$route->method("getParams")
			  ->willReturn([]);

		return $route;

	}

	function test___construct(){
		$di    = $this->getTestDi();
		$route = $this->getTestRoute();

		$controller = new TestController($di, $route);

		$this->assertInstanceOf("\\Chevron\\Kernel\\Controller\\Interfaces\\AbstractControllerInterface", $controller);
	}

}