<?php

namespace Chevron\Kernel\Dispatcher;

use Chevron\Kernel\Dispatcher\Traits\DiAwareTrait;
use Chevron\Kernel\Dispatcher\Traits\RouteAwareTrait;
use Chevron\Containers\Traits\ReflectiveDiMethodParamsTrait;
use Chevron\Kernel\Response\Traits\RedirectableControllerTrait;

abstract class AbstractDispatchableController implements Interfaces\DispatchableInterface {

	use InjectableMethodParamsInvocationTrait;
	use RedirectableControllerTrait;
	use DiAwareTrait;
	use RouteAwareTrait;

	public function __construct( $di, $route ){
		$this->setDi($di);
		$this->setRoute($route);
	}

	public function __invoke(){
		$action = $this->getRoute()->getAction();

		if(method_exists($this, $action)){
			return $this->callMethodFromReflectiveDiMethodParams($this->getDi(), $this, $action, func_get_args());
		}

		throw new \DomainException("Method not found: {$action}; via {$this->getRoute()}", 404);

	}

}
