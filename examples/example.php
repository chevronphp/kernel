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

$applicationNamespace = "\\ChevronWeb\\";
$controllerNamespace  = "\\ChevronWeb\\Controllers\\";

// autoloader(s) go here

// $di = Di goes here

$router = new Router\WebRouter;
$route  = $router->match($_SERVER["REQUEST_URI"]);

// create an object to collect headers
// $headers = new Response\Headers;

$dispatcher = new Dispatcher\Dispatcher($di);

try{
	$controller = $dispatcher->dispatch($controllerNamespace, $route);
}catch(Dispatcher\Exceptions\ControllerNotFoundException $e){
	$error = new Router\Route("ErrorController", "_404");
	$controller = $dispatcher->dispatch($controllerNamespace, $error);
}

/**
 * trade our controller for an invokable response
 */
$view = $controller();
if(!is_callable($view)){
	$error = new Router\Route("ErrorController", "_500");
	$controller = $dispatcher->dispatch($controllerNamespace, $error);
	$view = $controller();
}

// at some point you might want to SEND headers, but only if you want to
// $headers->eachHeader("header");

// exec the controller -- returns a *callable* ... most likely a view (maybe a closure)
$view = $controller();

// you might consider passing the view to a layout (for web)
$view();