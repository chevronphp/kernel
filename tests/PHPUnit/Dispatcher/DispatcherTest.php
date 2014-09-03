<?php

namespace Chevron\Kernel\DispatcherTests;

use \Chevron\Kernel\Dispatcher\Dispatcher;
use \Chevron\Kernel\Dispatcher\DispatchableInterface;

class BasicController implements DispatchableInterface {
	protected $called;
	function __construct($di, $route){}
	function __invoke(){ return $this; }
	function init(){ $this->called = 323; }
	function getCalled(){ return $this->called; }
}

class DispatcherTest extends \PHPUnit_Framework_TestCase {

	function getTestDi(){
		return $this->getMock("\\Chevron\\Containers\\Deferred");
	}

	function getTestRoute($type){
		$route = $this->getMock("\\Chevron\\Kernel\\Router\\Interfaces\\RouteInterface");

		$route->method("getController")
			  ->willReturn("DispatcherTests\\BasicController");

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

		$dispatcher = new Dispatcher($di, "Chevron\\Kernel\\");

		$controller = call_user_func($dispatcher->dispatch($route));

		// note the invokation
		$this->assertTrue($controller InstanceOf BasicController);
		$this->assertEquals($controller->getCalled() , 323);

	}


	/**
	 * @expectedException \Chevron\Kernel\Dispatcher\ControllerNotFoundException
	 */
	function test_ControllerNotFoundException(){

		$di    = $this->getTestDi();
		$route = $this->getTestRoute("BasicController");

		$dispatcher = new Dispatcher($di);
		$dispatcher->setNamespace("Chervo\\");

		$controller = $dispatcher->dispatch($route);

	}

}
