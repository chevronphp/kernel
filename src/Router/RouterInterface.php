<?php

namespace Chevron\Kernel\Router;
/**
 * the signature for our router
 *
 * @package Chevron\Kernel
 * @author Jon Henderson
 */
interface RouterInterface {

	/**
	 * get a Route based on the given $path
	 * @param string $path The path to parse
	 * @return \Chevron\Kernel\Router\Route
	 */
	function match($path);

}