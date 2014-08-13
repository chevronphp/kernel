<?php

namespace Chevron\Kernel\Response\Interfaces;

/**
 *
 */
interface HeadersInterface {


	/**
	 * @return array
	 */
	function getHeaders();

	/**
	 * @todo array values, separated with semicolons and comas dependent on their depth
	 *
	 * @param string $key
	 * @param string $value
	 * @return string The Composed Header
	 */
	function setHeader( $key, $value );

	/**
	 * Method to generate the correct content-type header for the response
	 *
	 * @param string $extension The type to retrieve
	 * @return string
	 */
	function detectContentTypeByExtension( $extension );

	/**
	 * @param string $url
	 * @param int    $statusCode
	 * @throws \Exception
	 */
	function setRedirect( $url, $statusCode = 302 );

	/**
	 * method to to generate the correct HTTP header for the response
	 *
	 * @param int $statusCode The status code to retrieve
	 * @return string
	 * @throws \Exception
	 */
	function setStatusCode( $statusCode );

	/**
	 * @param callable $callback
	 * @param bool     $extra
	 */
	function eachHeader( callable $callback, $extra = false );

}