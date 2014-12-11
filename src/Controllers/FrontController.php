<?php

namespace Chevron\Kernel\Controllers;

use Chevron\Kernel\Router;
use Chevron\Kernel\Dispatcher;

class FrontController {

	protected $di, $dispatcher, $route;
	protected $indexController, $errorController;

	/**
	 * create a new FrontController
	 * @param object $di The object to use as our Di
	 * @param Dispatcher\DispatcherInterface $dispatcher Our dispatcher
	 * @param Router\RouterInterface $router Our Router
	 * @return FrontController
	 */
	function __construct($di, Dispatcher\DispatcherInterface $dispatcher, Router\RouterInterface $router){
		if($di){
			$this->setDi($di);
		}

		if($dispatcher){
			$this->setDispatcher($dispatcher);
		}

		if($router){
			$this->setRouter($router);
		}
	}

	/**
	 * set the name of the index controller--the controller to use when no controller
	 * is named in the provided request (e.g. site.com/page.html)
	 */
	function setIndexController($objectName){
		$this->indexController = $objectName;
	}

	/**
	 * set the name of the error controller--the controller to use when an error is needed
	 */
	function setErrorController($objectName){
		$this->errorController = $objectName;
	}

	/**
	 * magic invoke shortcut
	 * @param string $route The $_SERVER[REQUEST_URI] to match
	 * @return callable
	 */
	function __invoke($route){
		return $this->invoke($route);
	}

	/**
	 * invoke
	 * @param string $route The $_SERVER[REQUEST_URI] to match
	 * @return callable
	 */
	function invoke($route){

		$route = $this->router->match($route);

		/**
		 * set up a default route for errors and empty requests ... "index"
		 * explicitly defining the defaul controller, allows us to avoid
		 * nesting try/catches around trying to invoke the controller
		 *
		 */
		if($this->errorController){
			$error = new Router\Route($this->errorController, $route->getAction());
		}

		/**
		 * the provided request should have a controller
		 */
		if(!$route->getController()){
			/**
			 * if not, have we set an index controller?
			 */
			if($this->indexController){
				$route = new Router\Route($this->indexController, $route->getAction());
			}else{
				/**
				 * if not, use the error controller to send a 404 (or other)
				 */
				$route = $error;
			}
		}

		try{

			/**
			 * `$controller()`
			 * call the dispatcher's lambda, in effect, exchanging it for the
		     * controller instance -- controller instances should return a
		     * callable to pass back to the calling script to inject
		     * into a layout or call explicitly
			 */

			$controller = $this->dispatcher->dispatch($route);
			$view       = call_user_func($controller);

		/**
		 * `call_user_func($controller, null, [404, $e])`
		 *  call the dispatcher's lambda, in effect, __invoke() on the
		 * error controller passing it a null method, and some args
		 * which ends up issuing the error
		 */

		}catch(Dispatcher\ControllerNotFoundException $e){

			$controller = $this->dispatcher->dispatch($error);
			$view       = call_user_func($controller, null, [404, $e]);

		}catch(ActionNotFoundException $e){

			$controller = $this->dispatcher->dispatch($error);
			$view       = call_user_func($controller, null, [404, $e]);

		}catch(\Exception $e){

			$controller = $this->dispatcher->dispatch($error);
			$view       = call_user_func($controller, null, [500, $e]);

		}

		return $view;

	}

	/**
	 * set up our dispatcher
	 */
	protected function setDispatcher(Dispatcher\DispatcherInterface $dispatcher){
		$this->dispatcher = $dispatcher;
	}

	/**
	 * parse our request into a Route
	 */
	protected function setRouter(Router\RouterInterface $router){
		$this->router = $router;
	}

	/**
	 * parse our request into a Route
	 */
	protected function setDi($di){
		$this->di = $di;
	}
}
