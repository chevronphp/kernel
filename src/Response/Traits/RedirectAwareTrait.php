<?php

namespace Chevron\Kernel\Response\Traits;

trait RedirectAwareTrait {

	/**
	 * @param string $url
	 * @param int    $statusCode
	 * @throws \Exception
	 */
	public function setRedirect( $url, $statusCode = 302 ) {
		if( intval($statusCode / 100) != 3 ) {
			throw new \Exception("{$statusCode} is not a valid redirect");
		}

		$this->setStatusCode($statusCode);
		$this->setHeader('Location', $url);
	}

}
