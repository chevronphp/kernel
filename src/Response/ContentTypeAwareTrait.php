<?php

namespace Chevron\Kernel\Response;

trait ContentTypeAwareTrait {

	protected $content_types = array(
		"json" => "application/json",
		"xml"  => "application/xml",
		"html" => "text/html",
		"txt"  => "text/plain",
	);

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

	abstract function setHeader($k, $v);

}
