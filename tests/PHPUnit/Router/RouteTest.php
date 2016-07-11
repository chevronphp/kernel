<?php

class RouteTest extends PHPUnit_Framework_TestCase {

	function test___construct(){
		$obj = new \Chevron\Kernel\Router\Route("\\Namespace\\Controller", "action", null, ["query" => "param"]);
		$this->assertEquals($obj->getController(), "\\Namespace\\Controller");
		$this->assertEquals($obj->getAction(), "action");
		$this->assertEquals($obj->getFormat(), null);
		$this->assertEquals($obj->getParams(), ["query" => "param"]);

	}

	function test_toArray(){
		$obj = new \Chevron\Kernel\Router\Route("\\Namespace\\Controller", "action", null, ["query" => "param"]);
		$result = $obj->toArray();
		$expected = [
			\Chevron\Kernel\Router\Route::CONTROLLER_KEY => "\\Namespace\\Controller",
			\Chevron\Kernel\Router\Route::ACTION_KEY     => "action",
			\Chevron\Kernel\Router\Route::FORMAT_KEY     => null,
			\Chevron\Kernel\Router\Route::PARAMS_KEY     => ["query" => "param"],
		];
		$this->assertEquals($expected, $result);
	}

	function test_getHash(){
		$obj = new \Chevron\Kernel\Router\Route("\\Namespace\\Controller", "action", null, ["query" => "param"]);
		$result = $obj->getHash();
		$expected = json_encode($obj->toArray());
		$expected = substr(sha1($expected), 0, 8);
		$this->assertEquals($expected, $result);
	}

}
