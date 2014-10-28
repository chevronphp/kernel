<?php

use Chevron\Kernel\Router;

class CliTestLog extends \Psr\Log\AbstractLogger {
	protected $container;
	function log($level, $message, array $context = []){
		$this->container = "{$level}|{$message}|" . count($context);
	}
	function getLog(){
		return $this->container;
	}
}

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

	function test_logRequest(){

		$_argv = ["frontControl", "name/space/class/method", "-f", "--val", "asdf"];

		$router = new Router\CliRouter;
		$logger = new CliTestLog;

		$router->setLogger($logger);

		$path = $_argv[1];
		$result = $router->match($path, array_slice($_argv, 2));

		$expected = "info|Chevron\\Kernel\\Router\\CliRouter|7";

		$this->assertEquals($expected, $logger->getLog());

	}

}