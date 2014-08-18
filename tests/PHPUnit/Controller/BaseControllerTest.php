<?php

namespace Chevron\Kernel\ControllerTests;

use \Chevron\Kernel\Controller\BaseController;

class TestBaseController extends BaseController {

	public $inited = false;

	function init(){
		$this->inited = true;
		return function(){ echo "w00t."; };
	}

	public $tested = false;

	function setTested(){
		$this->tested = true;
		return function(){ echo "w00t."; };
	}

}

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

		$controller->setAutoMethodFunc("");

		$view = $controller();
	}

	function test___construct_init(){
		$di    = $this->getTestDi();
		$route = $this->getTestRoute();

		$controller = new TestBaseController($di, $route);

		$this->assertEquals($controller->inited, false);

		$view = $controller();

		$this->assertEquals($controller->inited, true);

	}

	function test___construct_customInit(){
		$di    = $this->getTestDi();
		$route = $this->getTestRoute();

		$controller = new TestBaseController($di, $route);

		$this->assertEquals($controller->tested, false);

		$controller->setAutoMethodFunc("setTested");

		$view = $controller();

		$this->assertEquals($controller->tested, true);

	}

}