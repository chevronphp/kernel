<?php

if(!isset($argv[1])){ die("Please supply an example 'route' (e.g. index/index)\n\n"); }

require "vendor/autoload.php";

use \Chevron\Kernel\Router;
use \Chevron\Kernel\Dispatcher;

define("DIR_BASE", dirname(__FILE__));

require DIR_BASE . "/ActionNotFoundException.php";
require DIR_BASE . "/BaseController.php";
require DIR_BASE . "/IndexController.php";
require DIR_BASE . "/Di.php";
/**
 * load and populate our Di ... I like Chevron\Containers\Di
 */
$di = new Example\Di; // this would need a whole lot more to be real

/**
 * set up our dispatcher
 */
$dispatcher = new Dispatcher\Dispatcher($di, "\\Example\\");

/**
 * parse our request into a Route
 */
$route = (new Router\CliRouter)->match($argv[1]);

/**
 * set up a default route for errors and empty requests ... "index"
 * explicitly defining the defaul controller, allows us to avoid
 * nesting try/catches around trying to invoke th econtroller
 *
 */
$default = new Router\Route("IndexController", $route->getAction());

/**
 * check to see if the request is empty
 */
$route = $route->getController() ? $route : $default;

try{
	// try our requested controller -> action
	$controller = $dispatcher->dispatch($route);
	$view       = $controller();
}catch(Dispatcher\ControllerNotFoundException $e){
	// try out default controller -> 404
	$controller = $dispatcher->dispatch($default);
	$view       = $controller("_404");
}catch(Example\ActionNotFoundException $e){
	// try out default controller -> 404
	$controller = $dispatcher->dispatch($default);
	$view       = $controller("_404");
}catch(Exception $e){
	// something has gone VERY wrong
	$controller = $dispatcher->dispatch($default);
	$view       = $controller("_500");
}

/**
 * send our headers
 */
// this example $di returns nothing ...
// $di->get("response")->eachHeader("header");

// if you have a layout (Chevron\Widgets\Layout) you can set the view here as well

$view();

/**
 * exit?
 */
exit(0);