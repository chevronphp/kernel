<?php

namespace Chevron\Kernel\Router;
/**
 * A very simple router that takes a standard regex => controller and if
 * a match is found, returns the executed controller. This dynamic router
 * assumes that the dev knows REGEX.
 *
 * @package Chevron\Kernel
 * @author Jon Henderson
 */
class ShortRouter extends AbstractRouter implements RouterInterface {

	/**
	 * a map to store our pattern => controllers
	 */
	protected $patterns = [];

	/**
	 * checkout our path against our stored patterns
	 *
	 * @param string $path A string representing the path to be parsed -- $_SERVER[REQUEST_URI]
	 * @return mixed
	 */
	function match($path){
		if(!$this->patterns){ return null; }

		foreach($this->patterns as $regex => $controller){
			$matches = [];
			if( preg_match($regex, $path, $matches) ){

				$this->logRequest([
					"request.pattern" => $regex,
					"request.path"    => $path,
					"pattern.matches" => $matches,
				]);

				return call_user_func($controller, $matches);
			}
		}
	}

	/**
	 * set the pattern => controller pair for use in our router
	 * @param string $pattern The regex pattern
	 * @param callable $func The callable 'controller'
	 * @return void
	 */
	function regex($pattern, callable $func){
		$this->patterns[$pattern] = $func;
	}

}