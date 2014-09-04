<?php

use \Chevron\Kernel\Controller;
use \Chevron\Kernel\Dispatcher;
use \Chevron\Kernel\Response;
use \Chevron\Kernel\Router;

/**
 * This is only an example of how the KERNEL can work. Other features/components
 * are excluded.
 */

$baseDir = dirname(__DIR__);
$appDir  = "{$baseDir}/application";

$applicationNs = "\\ChevronWeb\\";
$controllerNs  = "\\ChevronWeb\\Controllers\\";

// autoloader(s) go here

// $di = Di goes here

$router = new Router\WebRouter;
$route  = $router->match($_SERVER["REQUEST_URI"]);

// create an object to collect headers
// $headers = new Response\Headers;

$dispatcher = new Dispatcher\Dispatcher( $di );

$error = new Router\Route("ErrorController");

try{
	$controller = $dispatcher->dispatch($controllerNs, $route);
	$method = "";
}catch(Dispatcher\Exceptions\ControllerNotFoundException $e){
	$controller = $dispatcher->dispatch($controllerNs, $error);
	$method = "_404";
}

// at some point you might want to SEND headers, but only if you want to
// $headers->eachHeader("header");

// exec the controller -- returns a *callable* ... most likely a view (maybe a closure)
$controller($method);