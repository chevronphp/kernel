<?php

namespace Chevron\Kernel\Dispatcher;

use Psr\Log;
use Chevron\Kernel\Router\RouteInterface;
use Chevron\Kernel\Traits\DiAwareTrait;
use Chevron\Kernel\Traits\RouteAwareTrait;
use Chevron\Kernel\Traits\InjectableMethodParamsInvocationTrait;
use Chevron\Kernel\Traits\RedirectableControllerTrait;

abstract class AbstractDispatchableController implements DispatchableInterface {

	use Log\LoggerAwareTrait;
	use InjectableMethodParamsInvocationTrait;
	use RedirectableControllerTrait;
	use DiAwareTrait;
	use RouteAwareTrait;

	function __construct( $di, $route ){
		$this->setDi($di);
		$this->setRoute($route);
	}

	abstract function init();

	function __invoke(){
		$action = $this->getRoute()->getAction();

		if(method_exists($this, $action)){
			return $this->callMethodFromReflectiveDiMethodParams($this->getDi(), $this, $action, func_get_args());
		}

		$this->logException(new ActionNotFoundException);
	}

	protected function logException(\Exception $e){
		if($this->logger InstanceOf Log\LoggerInterface){
			$this->logger->error(get_class($e), [
				"e.type"           => get_class($e),
				"e.message"        => $e->getMessage(),
				"e.code"           => $e->getCode(),
				"e.file"           => $e->getFile(),
				"e.line"           => $e->getLine(),
				"route.controller" => $this->getRoute()->getController(),
				"route.action"     => $this->getRoute()->getAction(),
				"route.format"     => $this->getRoute()->getFormat(),
				"route.params"     => $this->getRoute()->getParams(),
				"info.class"       => get_class($this),
			]);
		}
		throw $e;
	}

}
