<?php

/**
 * This is only an example of how the KERNEL can work. Other features/components
 * are excluded.
 */

// autoloader(s) go here

// $di = Di goes here

$router = new \Chevron\Kernel\Router\WebRouter;
$route  = $router->match($_SERVER["REQUEST_URI"]);

// create an object to collect headers

$dispatcher = new \Chevron\Kernel\Dispatcher\Dispatcher($di);

try{
	$controller = $dispatcher->dispatch("ChevronWeb\\Controllers\\", $route);
}catch(\Chevron\Kernel\Dispatcher\Exceptions\ControllerNotFoundException $e){
	$route = new \Chevron\Kernel\Router\Route("ErrorController", "_404");
	$controller = $dispatcher->dispatch("ChevronWeb\\Controllers\\", $route);
}

// at some point you might want to SEND headers, but only if you want to

// exec the controller -- returns a *callable* ... most likely a view (maybe a closure)
$view = $controller();

// you might consider passing the view to a layout (for web)
$view();