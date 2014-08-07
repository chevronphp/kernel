<?php

namespace Chevron\Kernel\Controller;
/**
 * parent for children classes needing base functionality
 * @package Chevron\Kernel
 */
abstract class BaseController implements Interfaces\AbstractControllerInterface {

	/**
	 * import our functionaltiy
	 */
	use Traits\BaseControllerTrait;

}
