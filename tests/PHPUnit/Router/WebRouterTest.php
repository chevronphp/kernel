<?php

use Chevron\Kernel\Router;

class WebRouterTest extends PHPUnit_Framework_TestCase {

	function test_parsePath_full(){
		$path = "name/space/class/method.json?query=params";

		$router = new Router\WebRouter;

		$result = $router->match($path);

		$expected = new Router\Route(
			"Name\\Space\\Class",
			"method",
			"json",
			["query" => "params"]
		);

		$this->assertInstanceOf("\\Chevron\\Kernel\\Router\\Route", $result);
		$this->assertEquals($expected, $result);

	}

	function test_parsePath_partial_1(){
		$path = "name/space/class/method?query=params";

		$router = new Router\WebRouter;

		$result = $router->match($path);

		$expected = new Router\Route(
			"Name\\Space\\Class",
			"method",
			"html",
			["query" => "params"]
		);

		$this->assertInstanceOf("\\Chevron\\Kernel\\Router\\Route", $result);
		$this->assertEquals($expected, $result);

	}

	function test_parsePath_partial_2(){
		$path = "name/space/class/?query=params";

		$router = new Router\WebRouter;

		$result = $router->match($path);

		$expected = new Router\Route(
			"Name\\Space\\Class",
			"index",
			"html",
			["query" => "params"]
		);

		$this->assertInstanceOf("\\Chevron\\Kernel\\Router\\Route", $result);
		$this->assertEquals($expected, $result);

	}

	function test_parsePath_partial_3(){
		$path = "name/space/class/";

		$router = new Router\WebRouter;

		$result = $router->match($path);

		$expected = new Router\Route(
			"Name\\Space\\Class",
			"index",
			"html",
			[]
		);

		$this->assertInstanceOf("\\Chevron\\Kernel\\Router\\Route", $result);
		$this->assertEquals($expected, $result);

	}

	function test_RouteInterface(){

		$obj = new Router\Route(
			"Name\\Space\\Class",
			"method",
			"html",
			["query" => "params"]
		);

		$this->assertEquals("Name\\Space\\Class", $obj->getController());
		$this->assertEquals("method", $obj->getAction());
		$this->assertEquals("html", $obj->getFormat());
		$this->assertEquals(["query" => "params"], $obj->getParams());

	}

	function test_RouteInterface_defaults(){

		$obj = new Router\Route(
			"Name\\Space\\Class"
		);

		$this->assertEquals("Name\\Space\\Class", $obj->getController());
		$this->assertEquals(null, $obj->getAction());
		$this->assertEquals(null, $obj->getFormat());
		$this->assertEquals([], $obj->getParams());

	}

}