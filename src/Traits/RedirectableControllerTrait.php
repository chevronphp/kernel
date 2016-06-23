<?php

namespace Chevron\Kernel\Traits;

trait RedirectableControllerTrait {

	/**
	 * @return \Capstone\Di\DiInterface
	 */
	abstract public function getDi();

	public function redirect( $url ) {
		/**
		 * @var \Capstone\HTTP\Utils\Fulfillment $fulfillment
		 * @var \Capstone\Stubs\LayoutWidget     $layout
		 */
		$fulfillment = $this->getDi()->get("fulfillment");
		// $layout = $this->getDi()->get("layout");

		// $layout->setLayout('raw');
		$fulfillment->setRedirect($url);

		return function () use ($url) {
			echo "Redirecting to: {$url}";
		};
	}
}
