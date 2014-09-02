<?php

namespace Chevron\Kernel\Response;

/**
 *
 */
class Headers implements Interfaces\HeadersInterface {

	use Traits\StatusCodesTrait;
	use Traits\ContentTypesTrait;

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

	/**
	 * Method to generate the correct content-type header for the response
	 *
	 * @param string $extension The type to retrieve
	 * @return string
	 */
	public function setContentType( $extension ) {
		$extension = strtolower(trim($extension, " ."));

		$value = "text/html";
		if(isset($this->content_types[$extension])){
			$value = $this->content_types[$extension];
		}

		return $this->setHeader('Content-Type', $value);
	}


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

	/**
	 * method to to generate the correct HTTP header for the response
	 *
	 * @param int $statusCode The status code to retrieve
	 * @return string
	 * @throws \Exception
	 */
	public function setStatusCode( $statusCode ) {

		if( !isset($this->status_codes[$statusCode]) ) {
			throw new \Exception("Unknown Status Code {$statusCode}", $statusCode);
		}

		$header = "HTTP/1.1 {$statusCode} " . $this->status_codes[$statusCode];
		$this->setHeader(static::HEADER_STATUS_CODE, $header);

		return $header;
	}

}