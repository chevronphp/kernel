<?php

namespace Chevron\Kernel\Response\Traits;

trait RedirectAwareTrait {

	/**
	 * @param string $url
	 * @param int    $statusCode
	 * @throws \Exception
	 * @return void
	 */
	public function setRedirect( $url, $statusCode = 302 ) {
		if( intval($statusCode / 100) != 3 ) {
			throw new \InvalidArgumentException("{$statusCode} is not a valid redirect");
		}

		$this->setStatusCode($statusCode);
		$this->setHeader('Location', $url);
	}

	/**
	 * @param string $k
	 * @param string $v
	 */
	public abstract function setHeader($k, $v);

	/**
	 * @param string $v
	 */
	public abstract function setStatusCode($v);

}
