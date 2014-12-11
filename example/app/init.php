#!/usr/bin/env php
<?php

use Corpus\Autoloader\Psr0;
use Chevron\ErrHandler\ErrorHandler;
use Chevron\ErrHandler\ExceptionHandler;
use Chevron\ObjectLoader\ObjectLoader;
use Chevron\Containers\Di;
use Chevron\Kernel\Dispatcher\Dispatcher;
use Chevron\Kernel\Router\CliRouter;
use Chevron\Kernel\Controllers\FrontController;

define("DIR_BASE", dirname(__FILE__));
require dirname(DIR_BASE) . "/vendor/autoload.php";

spl_autoload_register(new Psr0(DIR_BASE . "/app/classes"));

set_error_handler(new ErrorHandler);
set_exception_handler(new ExceptionHandler(ExceptionHandler::ENV_DEV));

$di         = (new ObjectLoader)->loadObject(new Di, DIR_BASE . "/app/services");
$dispatcher = new Dispatcher($di);
$router     = new CliRouter;

$app        = new FrontController($di, $dispatcher, $router);

// $argv[1]
$route = is_cli() ? $_SERVER["argv"] : $_SERVER["REQUEST_URI"];

$view = $app->invoke($route);

call_user_func($view);

exit(0);


