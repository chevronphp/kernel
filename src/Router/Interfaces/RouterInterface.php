<?php

namespace Chevron\Kernel\Router\Interfaces;

interface RouterInterface {

	/**
	 * get a Route based on the given $path
	 * @param string $path The path to parse
	 * @return \Chevron\Router\Route
	 */
	function match($path, array $params);

}