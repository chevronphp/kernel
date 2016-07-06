<?php

namespace Chevron\Kernel\Dispatcher\Interfaces;

/**
 * our dispatcher is very simple
 * @package Chevron\Kernel
 */
interface DispatchableInitializationInterface {

	const INIT = "init";

	/**
	 * get $di
	 */
	public function init($action = "");

}
