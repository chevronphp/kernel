<?php

namespace Chevron\Kernel\Router;
/**
 * A very simple and quite opinionated routing system, this is here ONLY to tweak
 * inheritence later on if I get the urge.
 *
 * @package Chevron\Kernel
 * @author Jon Henderson
 */
abstract class AbstractRouter {

	use Traits\DefaultActionAwareTrait;
	use Traits\DefaultFormatAwareTrait;

}