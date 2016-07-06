<?php

use Chevron\Kernel\Router;

class RegexRouterTest extends PHPUnit_Framework_TestCase {

	function test_match_1(){

		$path = "namespace/action.html";

		$router = new Router\RegexRouter;

		$router->regex("/(?P<ns>[a-z]*)\/(?P<act>.*)\$/i", function($matches){
			return $matches["act"];
		});


		$result = $router->match($path);

		$expected = "action.html";

		$this->assertEquals($expected, $result);

	}

	function test_match_2(){

		$path = "namespace2/action.html";

		$router = new Router\RegexRouter;

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

		$router = new Router\RegexRouter;

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

}
