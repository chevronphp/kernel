<?php

namespace Chevron\Kernel\DispatcherTests;

use \Chevron\Kernel\Dispatcher\Dispatcher;

class BasicController {
	function __invoke(){}
}

class DispatcherTest extends \PHPUnit_Framework_TestCase {

	function getTestDi(){
		return $this->getMock("\\Chevron\\Containers\\Deferred");
	}

	function getTestRoute(){
		$route = $this->getMock("\\Chevron\\Kernel\\Router\\Interfaces\\RouteInterface");

		$route->method("getController")
			  ->willReturn('DispatcherTests\\BasicController');

		$route->method("getAction")
			  ->willReturn('ActionThings');

		$route->method("getFormat")
			  ->willReturn('html');

		$route->method("getParams")
			  ->willReturn([]);

		return $route;

	}

	function test_dispatch(){

		$di    = $this->getTestDi();
		$route = $this->getTestRoute();

		$router = new Dispatcher($di);

		$controller = $router->dispatch("Chevron\\Kernel\\", $route);

		$this->assertTrue(is_callable($controller));

	}

	/**
	 * @expectedException \Chevron\Kernel\Dispatcher\Exceptions\ControllerNotFoundException
	 */
	function test_ControllerNotFoundException(){

		$di    = $this->getTestDi();
		$route = $this->getTestRoute();

		$router = new Dispatcher($di);

		$controller = $router->dispatch("Chervo\\", $route);

	}

}
