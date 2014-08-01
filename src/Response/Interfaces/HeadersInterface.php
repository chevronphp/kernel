<?php

namespace Chevron\Kernel\Response\Interfaces;

/**
 *
 */
class HeadersInterface {


	/**
	 * @return array
	 */
	public function getHeaders();

	/**
	 * @todo array values, separated with semicolons and comas dependent on their depth
	 *
	 * @param string $key
	 * @param string $value
	 * @return string The Composed Header
	 */
	public function setHeader( $key, $value );

	/**
	 * @param $key
	 * @param $value
	 * @return string
	 */
	protected function composeHeader( $key, $value );

	/**
	 * Method to generate the correct content-type header for the response
	 *
	 * @param string $extension The type to retrieve
	 * @return string
	 */
	public function detectContentTypeByExtension( $extension );

	/**
	 * @param string $url
	 * @param int    $statusCode
	 * @throws \Exception
	 */
	public function setRedirect( $url, $statusCode = 302 );

	/**
	 * method to to generate the correct HTTP header for the response
	 *
	 * @param int $statusCode The status code to retrieve
	 * @return string
	 * @throws \Exception
	 */
	public function setStatusCode( $statusCode );

	/**
	 * @param callable $callback
	 * @param bool     $extra
	 */
	public function eachHeader( callable $callback, $extra = false );

}