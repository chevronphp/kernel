<?php

namespace Chevron\Kernel\Response;

/**
 *
 */
class Headers implements Interfaces\HeadersInterface {

	use Traits\StatusCodeAwareTrait;
	use Traits\ContentTypeAwareTrait;
	use Traits\RedirectAwareTrait;

	const HEADER_STATUS_CODE = 102;

	/**
	 * @var array
	 */
	protected $headers = array();

	/**
	 * @return array
	 */
	public function getHeaders() {
		return $this->headers;
	}

	/**
	 * @todo array values, separated with semicolons and comas dependent on their depth
	 *
	 * @param string $key
	 * @param string $value
	 * @return string The Composed Header
	 */
	public function setHeader( $key, $value ) {
		$this->headers[$key] = $value;

		return $this->composeHeader($key, $value);
	}

	/**
	 * @param $key
	 * @param $value
	 * @return string
	 */
	protected function composeHeader( $key, $value ) {
		$key = strval($key);
		if( is_numeric($key) ) {
			return $value;
		}

		return "{$key}: {$value}";
	}

	/**
	 * @param callable $callback
	 * @param bool     $extra
	 * @return void
	 */
	public function eachHeader( callable $callback, $extra = false ) {
		foreach( $this->headers as $key => $value ) {
			$header = $this->composeHeader($key, $value);

			if( !$extra ) {
				$callback($header);
			} else {
				$callback($header, $key, $value);
			}
		}
	}

}