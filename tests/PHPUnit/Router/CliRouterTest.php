<?php

use Chevron\Kernel\Router;

class CliRouterTest extends PHPUnit_Framework_TestCase {

	function test_parsePath(){

		$_argv = ["frontControl", "name/space/class/method", "-f", "--val", "asdf"];

		$router = new Router\CliRouter;

		$path = $_argv[1];
		$result = $router->match($path, array_slice($_argv, 2));

		$expected = new Router\Route(
			"Name\\Space\\Class",
			"method",
			null,
			["-f", "--val", "asdf"]
		);

		$this->assertInstanceOf("\\Chevron\\Kernel\\Router\\Route", $result);
		$this->assertEquals($expected, $result);

	}

}