<?php

namespace Chevron\Kernel\Controller\Interfaces;

use \Chevron\Containers\Interfaces\DiInterface;
use \Chevron\Kernel\Router\Interfaces\RouteInterface;

interface AbstractControllerInterface {

	function __construct(DiInterface $di, RouteInterface $route);

	function __invoke();

}