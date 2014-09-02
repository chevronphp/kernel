<?php

class ResponseTest extends PHPUnit_Framework_TestCase {

	function getObj(){
		return new \Chevron\Kernel\Response\Headers;
	}

	function test_getHeaders() {
		$obj = $this->getObj();

		$obj->setHeader("X-PHPUNIT-TEST_PARAM_1", "Chevron");
		$obj->setHeader("X-PHPUNIT-TEST_PARAM_2", "PHPUnit");

		$headers = $obj->getHeaders();

		$this->assertEquals($headers["X-PHPUNIT-TEST_PARAM_1"], "Chevron");
		$this->assertEquals($headers["X-PHPUNIT-TEST_PARAM_2"], "PHPUnit");
	}


	function test_setContentType( ) {
		$obj = $this->getObj();
		$expected = $obj->setContentType("html");
		$this->assertEquals($expected, "Content-Type: text/html");
	}


	function test_eachHeader( ) {

		$obj = $this->getObj();

		$obj->setHeader("X-PHPUNIT-TEST_PARAM_1", "Chevron");
		$obj->setHeader("X-PHPUNIT-TEST_PARAM_2", "PHPUnit");

		ob_start();
		$headers = $obj->eachHeader(function($header){
			echo strtoupper($header)."\n";
		});
		$expected = ob_get_clean();

		$this->assertEquals($expected, "X-PHPUNIT-TEST_PARAM_1: CHEVRON\nX-PHPUNIT-TEST_PARAM_2: PHPUNIT\n");

	}


	function test_setRedirect( ) {
		$obj = $this->getObj();

		$obj->setRedirect("http://phpunit.de");

		$headers = $obj->getHeaders();

		$this->assertEquals($headers[102], "HTTP/1.1 302 Found");
		$this->assertEquals($headers["Location"], "http://phpunit.de");
	}

	/**
	 * @expectedException \Exception
	 */
	function test_setRedirect_Exception( ) {
		$obj = $this->getObj();
		$obj->setRedirect("http://phpunit.de", 404);
	}

}