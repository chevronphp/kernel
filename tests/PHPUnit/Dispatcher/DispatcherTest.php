<?php

namespace Chevron\Kernel\DispatcherTests;

use \Chevron\Kernel\Dispatcher\Dispatcher;

class BasicController {
	function __construct(){}
	function __invoke(){}
}

class BasicController2 {
	private function __construct(){}
	function __invoke(){}
}

class BasicController3 {
	function __invoke(){}
}

class DispatcherTest extends \PHPUnit_Framework_TestCase {

	function getTestDi(){
		return $this->getMock("\\Chevron\\Containers\\Deferred");
	}

	function getTestRoute($type){
		$route = $this->getMock("\\Chevron\\Kernel\\Router\\Interfaces\\RouteInterface");

		$route->method("getController")
			  ->willReturn("DispatcherTests\\{$type}");

		$route->method("getAction")
			  ->willReturn("ActionThings");

		$route->method("getFormat")
			  ->willReturn("html");

		$route->method("getParams")
			  ->willReturn([]);

		return $route;

	}

	function test_dispatch(){

		$di    = $this->getTestDi();
		$route = $this->getTestRoute("BasicController");

		$router = new Dispatcher($di);

		$controller = $router->dispatch("Chevron\\Kernel\\", $route);

		$this->assertTrue(is_callable($controller));
		$this->assertTrue($controller InstanceOf BasicController);

	}

	/**
	 * @expectedException \Chevron\Kernel\Dispatcher\Exceptions\InaccessibleConstructorException
	 */
	function test_dispatch_catch_private(){

		$di    = $this->getTestDi();
		$route = $this->getTestRoute("BasicController2");

		$router = new Dispatcher($di);

		$controller = $router->dispatch("Chevron\\Kernel\\", $route, [5,6,7,$di]);

		$this->assertTrue(is_callable($controller));
		$this->assertTrue($controller InstanceOf BasicController2);

	}

	function test_dispatch_catch_without(){

		$di    = $this->getTestDi();
		$route = $this->getTestRoute("BasicController3");

		$router = new Dispatcher($di);

		$controller = $router->dispatch("Chevron\\Kernel\\", $route, [5,6,7,$di]);

		$this->assertTrue(is_callable($controller));
		$this->assertTrue($controller InstanceOf BasicController3);

	}

	/**
	 * @expectedException \Chevron\Kernel\Dispatcher\Exceptions\ControllerNotFoundException
	 */
	function test_ControllerNotFoundException(){

		$di    = $this->getTestDi();
		$route = $this->getTestRoute("BasicController");

		$router = new Dispatcher($di);

		$controller = $router->dispatch("Chervo\\", $route);

	}

}
