<?php

use Chevron\Kernel\Router;

class ShortTestLog extends \Psr\Log\AbstractLogger {
	protected $container;
	function log($level, $message, array $context = []){
		$this->container = "{$level}|{$message}|" . count($context);
	}
	function getLog(){
		return $this->container;
	}
}

class ShortRouterTest extends PHPUnit_Framework_TestCase {

	function test_match_1(){

		$path = "namespace/action.html";

		$router = new Router\ShortRouter;

		$router->regex("/(?P<ns>[a-z]*)\/(?P<act>.*)\$/i", function($matches){
			return $matches["act"];
		});


		$result = $router->match($path);

		$expected = "action.html";

		$this->assertEquals($expected, $result);

	}

	function test_match_2(){

		$path = "namespace2/action.html";

		$router = new Router\ShortRouter;

		$router->regex("/namespace1\/(?P<act>.*)\$/i", function($matches){
			return $matches["act"];
		});

		$router->regex("/namespace2\/(?P<act>.*)\$/i", function($matches){
			return ucwords($matches["act"]);
		});

		$router->regex("/namespace2\/(?P<act>.*)\$/i", function($matches){
			return strtr($matches["act"], ".", "-");
		});


		$result = $router->match($path);

		$expected = "action-html";

		$this->assertEquals($expected, $result);

	}

	function test_match_3(){

		$path = "/namespace2/action.html";

		$router = new Router\ShortRouter;

		$Obj = new stdClass;

		$router->regex("/namespace2\/(?P<act>.*?)\.html\$/i", function($matches)use($Obj){
			$Obj->prop = ucwords($matches["act"]);
		});

		$router->regex("/namespace2\/(?P<act>.*)\$/i", function($matches)use($Obj){
			$Obj->prop = strtr($matches["act"], ".", "-");
		});


		$router->match($path);

		$expected = "Action";

		$this->assertEquals($expected, $Obj->prop);

	}

	function test_log_match(){

		$path = "/namespace2/action.html";

		$router = new Router\ShortRouter;

		$logger = new ShortTestLog;

		$router->setLogger($logger);

		$Obj = new stdClass;

		$router->regex("/namespace2\/(?P<act>.*?)\.html\$/i", function($matches)use($Obj){
			$Obj->prop = ucwords($matches["act"]);
		});

		$router->regex("/namespace2\/(?P<act>.*)\$/i", function($matches)use($Obj){
			$Obj->prop = strtr($matches["act"], ".", "-");
		});

		$router->match($path);

		$expected = "info|Chevron\\Kernel\\Router\\ShortRouter|3";

		$this->assertEquals($expected, $logger->getLog());

	}

}