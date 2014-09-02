<?php

namespace Chevron\Kernel\Response\Traits;

trait ContentTypesTrait {

	protected $content_types = array(
		"json" => "application/json",
		"xml"  => "application/xml",
		"html" => "text/html",
		"txt"  => "text/plain",
	);

}
