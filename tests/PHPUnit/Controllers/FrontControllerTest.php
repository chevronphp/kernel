<?php

class MockDi {
	function __call($name, $args){
		return null;
	}
}

class MockBaseController extends \Chevron\Kernel\Dispatcher\AbstractDispatchableController {
	function init(){} /* noop */
	function index(){
		return "base";
	}
}

class MockIndexController extends \Chevron\Kernel\Dispatcher\AbstractDispatchableController {
	function init(){} /* noop */
	function index(){
		return "index";
	}
}

class MockErrorController extends \Chevron\Kernel\Dispatcher\AbstractDispatchableController {
	function init(){} /* noop */
	function index($method, $args = []){
		list($code, $e) = $args;
		return $code;
	}
}

class MockNoMethodController extends \Chevron\Kernel\Dispatcher\AbstractDispatchableController {
	function init(){} /* noop */
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

class FrontControllerTest extends PHPUnit_Framework_TestCase {

	function getDiMock(){
		return new MockDi;
	}

	function getRouteMock(){
		return new \Chevron\Kernel\Router\Route("MockBaseController", "index");
	}

	function getDispatcherMock(){

		$di    = $this->getDiMock();
		$route = $this->getRouteMock();

		$mock = $this->getMock("Chevron\\Kernel\\Dispatcher\\DispatcherInterface");
		return $mock;
	}

	function getRouterMock(){

		$route = $this->getRouteMock();

		$mock = $this->getMock("Chevron\\Kernel\\Router\\RouterInterface");
		$mock->method('match')
			 ->willReturn($route);
		return $mock;
	}

	function test_normal(){

		$di         = $this->getDiMock();
		$dispatcher = $this->getDispatcherMock();
		$router     = $this->getRouterMock();
		$route      = $this->getRouteMock();

		$dispatcher->method('dispatch')
			 ->willReturn(new MockBaseController($di, $route));

		$app = new Chevron\Kernel\Controllers\FrontController($di, $dispatcher, $router);
		$app->setIndexController("MockIndexController");
		$app->setErrorController("MockErrorController");

		$result = $app("/index.html");

		$this->assertEquals("base", $result);

	}

	function test_indexController(){

		$di         = $this->getDiMock();
		$dispatcher = $this->getDispatcherMock();
		$router     = $this->getRouterMock();
		$route      = $this->getRouteMock();

		$dispatcher->method('dispatch')
			 ->willReturn(new MockIndexController($di, $route));

		$app = new Chevron\Kernel\Controllers\FrontController($di, $dispatcher, $router);
		$app->setIndexController("MockIndexController");
		$app->setErrorController("MockErrorController");

		$result = $app("/index.html");

		$this->assertEquals("index", $result);

	}

	function test_ControllerNotFoundException(){

		$di         = $this->getDiMock();
		$dispatcher = $this->getDispatcherMock();
		$router     = $this->getRouterMock();
		$route      = $this->getRouteMock();

		$dispatcher->method('dispatch')
			 ->will($this->onConsecutiveCalls(
				$this->throwException(new Chevron\Kernel\Dispatcher\ControllerNotFoundException),
				new MockErrorController($di, $route)
			));

		$app = new Chevron\Kernel\Controllers\FrontController($di, $dispatcher, $router);
		$app->setIndexController("MockIndexController");
		$app->setErrorController("MockErrorController");

		$result = $app("/foo.html");

		$this->assertEquals(404, $result);

	}

	function test_ActionNotFoundException(){

		$di         = $this->getDiMock();
		$dispatcher = $this->getDispatcherMock();
		$router     = $this->getRouterMock();
		$route      = $this->getRouteMock();

		$dispatcher->method('dispatch')
			 ->will($this->onConsecutiveCalls(
				$this->throwException(new Chevron\Kernel\Dispatcher\ActionNotFoundException),
				new MockErrorController($di, $route)
			));

		$app = new Chevron\Kernel\Controllers\FrontController($di, $dispatcher, $router);
		$app->setIndexController("MockIndexController");
		$app->setErrorController("MockErrorController");

		$result = $app("/bar.html");

		$this->assertEquals(404, $result);

	}

	function test_Exception(){

		$di         = $this->getDiMock();
		$dispatcher = $this->getDispatcherMock();
		$router     = $this->getRouterMock();
		$route      = $this->getRouteMock();

		$dispatcher->method('dispatch')
			 ->will($this->onConsecutiveCalls(
				$this->throwException(new Exception),
				new MockErrorController($di, $route)
			));

		$app = new Chevron\Kernel\Controllers\FrontController($di, $dispatcher, $router);
		$app->setIndexController("MockIndexController");
		$app->setErrorController("MockErrorController");

		$result = $app("/bar.html");

		$this->assertEquals(500, $result);

	}

	function test_AbstractDispatchableController_logging(){

		$di         = $this->getDiMock();
		$dispatcher = $this->getDispatcherMock();
		$router     = $this->getRouterMock();
		$route      = $this->getRouteMock();

		$mock = new MockNoMethodController($di, $route);
		$logger = new TestLog;
		$mock->setLogger($logger);

		$dispatcher->method('dispatch')
			 ->willReturn($mock);

		$app = new Chevron\Kernel\Controllers\FrontController($di, $dispatcher, $router);
		$app->setIndexController("MockIndexController");
		$app->setErrorController("MockErrorController");

		try{
			$result = $app("/bar.html");
		}catch(\Exception $e){
			$expected = "error|Chevron\\Kernel\\Dispatcher\\ActionNotFoundException|10";
			$this->assertEquals($expected, $logger->getLog());
		}

	}

}