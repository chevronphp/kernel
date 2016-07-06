<?php

namespace Chevron\Kernel\DispatcherTests;

use \Chevron\Kernel\Dispatcher\Dispatcher;
use \Chevron\Kernel\Dispatcher\Interfaces\DispatchableInterface;
use \Chevron\Kernel\Dispatcher\Interfaces\DispatchableInitializationInterface;

class BasicController implements DispatchableInterface, DispatchableInitializationInterface {
	protected $called;
	function __construct($di, $route){}
	function __invoke(){ return $this; }
	function init($action = ""){ $this->called = 323; }
	function getCalled($int = 0){ return $this->called + (int)$int; }
	function getDi(){ return $this->di; }
	function getRoute(){ return $this->route; }
}

class DispatcherTest extends \PHPUnit_Framework_TestCase {

	function getTestDi(){
		return new \stdClass;
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

		$lambda = $dispatcher->dispatch($route);

		// note the invokation -- the lambda wraps the routed object (controller)
		// simple invokation calls __invoke on the controller -- our test returns $this
		// in the real world, __invoke should do something meaningful ...
		$this->assertTrue($lambda() InstanceOf DispatchableInterface);
		// since __invoke returns $this, call a method of our controller
		$this->assertEquals($lambda()->getCalled() , 323);
		// the lambda acts as the wrapper for our object and allows us to pass method names and args to our controller
		$this->assertEquals($lambda("getCalled") , 323);
		$this->assertEquals($lambda("getCalled", [4]) , 327);
		// in a frontend controller, your wrapper would call a method (or __invoke) on our desired object and that
		// method might in turn return a callable (perhaps a view) that is then sent somewhere else or
		// invoked itself.
	}

	/**
	 * @expectedException \DomainException
	 */
	function test_ControllerNotFoundException(){

		$di    = $this->getTestDi();
		$route = $this->getTestRoute("BasicController");

		$dispatcher = new Dispatcher($di);
		$dispatcher->setNamespace("Chervo\\");

		$controller = $dispatcher->dispatch($route);

	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	function test_ActionNotFoundException(){

		$di    = $this->getTestDi();
		$route = $this->getTestRoute("BasicController");

		$dispatcher = new Dispatcher($di, "Chevron\\Kernel\\");

		$controller = $dispatcher->dispatch($route);

		call_user_func($controller, "NotAMethod");

	}

}
