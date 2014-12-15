<?php

namespace Chevron\Kernel\DispatcherTests;

use \Chevron\Kernel\Dispatcher\Dispatcher;
use \Chevron\Kernel\Dispatcher\DispatchableInterface;

class BasicController implements DispatchableInterface {
	protected $called;
	function __construct($di, $route){}
	function __invoke(){ return $this; }
	function init(){ $this->called = 323; }
	function getCalled($int = 0){ return $this->called + (int)$int; }
}

class TestLog extends \Psr\Log\AbstractLogger {
	protected $container;
	function log($level, $message, array $context = []){
		$this->container = "{$level}|{$message}|" . count($context);
	}
	function getLog(){
		return $this->container;
	}
}

class DispatcherTest extends \PHPUnit_Framework_TestCase {

	function getTestDi(){
		return new \stdClass;
	}

	function getTestRoute($type){
		$route = $this->getMock("\\Chevron\\Kernel\\Router\\RouteInterface");

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
	 * @expectedException \Chevron\Kernel\Dispatcher\ControllerNotFoundException
	 */
	function test_ControllerNotFoundException(){

		$di    = $this->getTestDi();
		$route = $this->getTestRoute("BasicController");

		$dispatcher = new Dispatcher($di);
		$dispatcher->setNamespace("Chervo\\");

		$controller = $dispatcher->dispatch($route);

	}

	/**
	 * @expectedException \Chevron\Kernel\Dispatcher\ActionNotFoundException
	 */
	function test_ActionNotFoundException(){

		$di    = $this->getTestDi();
		$route = $this->getTestRoute("BasicController");

		$dispatcher = new Dispatcher($di, "Chevron\\Kernel\\");

		$controller = $dispatcher->dispatch($route);

		call_user_func($controller, "NotAMethod");

	}

	function test_ControllerNotFoundExceptionLogging(){

		$di    = $this->getTestDi();
		$route = $this->getTestRoute("BasicController");

		$logger = new TestLog;

		$dispatcher = new Dispatcher($di);
		$dispatcher->setLogger($logger);
		$dispatcher->setNamespace("Chervo\\");

		try{
			$controller = $dispatcher->dispatch($route);
		}catch(\Exception $e){
			$expected = "error|Chevron\\Kernel\\Dispatcher\\ControllerNotFoundException|9";
			$this->assertEquals($expected, $logger->getLog());
		}

	}

}
