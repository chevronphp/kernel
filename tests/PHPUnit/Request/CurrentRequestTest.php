<?php

class CurrentRequestTest extends PHPUnit_Framework_TestCase {

	public function test_current_request_type(){

		// CurrentRequest is dependent on the $_SERVER array set in the phpunit XML manifest
		$request = new \Chevron\Kernel\Request\CurrentRequest(false);

		$this->assertInstanceOf("\Chevron\Kernel\Request\BaseRequest", $request);

	}

	/**
	 * @depends test_current_request_type
	 */
	public function test_current_request_structure(){

		// CurrentRequest is dependent on the $_SERVER array set in the phpunit XML manifest
		$request = new \Chevron\Kernel\Request\CurrentRequest(false);

		$expected = array(
			"getScheme"           => "http",
			"getHost"             => "local.chevron.com",
			"getPort"             => "80",
			"getPath"             => "/local/file/index.html",
			"getQuery"            => "a=b&c=d",
			"getSubDomain"       => "local",
			"getDomain"           => "chevron",
			"getTopLevelDomain" => "com",
			"getUser"             => "",
			"getPass"             => "",
			"getQueryArr"        => array(
				"a" => "b",
				"c" => "d",
			),
			"getDirname"          => "/local/file",
			"getBasename"         => "index.html",
			"getExtension"        => "html",
			"getFilename"         => "index",
			"getAction"           => "GET",
		);

		foreach($expected as $method => $value){
			$this->assertEquals($request->$method(), $value);
		}

	}

	public function test_pwd(){
		$request = new \Chevron\Kernel\Request\CurrentRequest(false);

		$original = $request->build();

		$result = $request->pwd("new_file.html");

		$url = "/local/file/new_file.html?a=b&c=d";

		$this->assertEquals($result, $url);
		$this->assertNotEquals($result, $original);
	}

	public function test_is_post(){
		$request = new \Chevron\Kernel\Request\CurrentRequest(false);

		$result = $request->is_post();

		$this->assertFalse($result);
	}

}