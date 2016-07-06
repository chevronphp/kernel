<?php

namespace Chevron\Kernel\Response\Interfaces;

/**
 *
 */
interface HeadersInterface {


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
	 * Method to generate the correct content-type header for the response
	 *
	 * @param string $extension The type to retrieve
	 * @return string
	 */
	public function setContentType( $extension );

	/**
	 * @param string $url
	 * @param int    $statusCode
	 * @return void
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
	 * @return void
	 */
	public function eachHeader( callable $callback, $extra = false );

}
