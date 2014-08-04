<?php

class BaseRequestTest extends PHPUnit_Framework_TestCase {

	public function test_construct(){

		$request = new \Chevron\Kernel\Request\BaseRequest;

		$this->assertInstanceOf("\Chevron\Kernel\Request\BaseRequest", $request, "CurrentRequest::__construct failed to return an object of the proper type");
	}

	public function test_construct_with_relative_url(){
		$url = "/dir/file.html?qry=str&snow=white";

		$request = new \Chevron\Kernel\Request\BaseRequest($url);

		$expected = array(
			"getScheme"           => "",
			"getHost"             => "",
			"getPort"             => "",
			"getPath"             => "/dir/file.html",
			"getQuery"            => "qry=str&snow=white",
			"getSubDomain"       => "",
			"getDomain"           => "",
			"getTopLevelDomain" => "",
			"getUser"             => "",
			"getPass"             => "",
			"getQueryArr"        => array(
				"qry"=>"str",
				"snow"=>"white"
			),
			"getDirname"          => "/dir",
			"getBasename"         => "file.html",
			"getExtension"        => "html",
			"getFilename"         => "file",
			"getAction"           => "GET",
		);

		foreach($expected as $method => $value){
			$this->assertEquals($request->$method(), $value);
		}

	}

	public function test_construct_with_absolute_url(){
		$url = "http://local.testing.com/dir/file.html?qry=str&snow=white";

		$request = new \Chevron\Kernel\Request\BaseRequest($url);

		$expected = array(
			"getScheme"           => "http",
			"getHost"             => "local.testing.com",
			"getPort"             => "",
			"getPath"             => "/dir/file.html",
			"getQuery"            => "qry=str&snow=white",
			"getSubDomain"       => "local",
			"getDomain"           => "testing",
			"getTopLevelDomain" => "com",
			"getUser"             => "",
			"getPass"             => "",
			"getQueryArr"        => array(
				"qry"=>"str",
				"snow"=>"white"
			),
			"getDirname"          => "/dir",
			"getBasename"         => "file.html",
			"getExtension"        => "html",
			"getFilename"         => "file",
			"getAction"           => "GET",
		);

		foreach($expected as $method => $value){
			$this->assertEquals($request->$method(), $value);
		}

	}

	public function test_construct_with_params(){
		$url = "http://local.testing.com/dir/file.html?qry=str&snow=white";

		$additional = array(
			"seven" => "little people"
		);

		$request = new \Chevron\Kernel\Request\BaseRequest($url, $additional);

		$expected = array(
			"getScheme"           => "http",
			"getHost"             => "local.testing.com",
			"getPort"             => "",
			"getPath"             => "/dir/file.html",
			"getQuery"            => "seven=little+people",
			"getSubDomain"       => "local",
			"getDomain"           => "testing",
			"getTopLevelDomain" => "com",
			"getUser"             => "",
			"getPass"             => "",
			"getQueryArr"        => array("seven" => "little people"),
			"getDirname"          => "/dir",
			"getBasename"         => "file.html",
			"getExtension"        => "html",
			"getFilename"         => "file",
			"getAction"           => "GET",
		);

		foreach($expected as $method => $value){
			$this->assertEquals($request->$method(), $value);
		}

	}

	public function test_parse_extended(){
		$request = new \Chevron\Kernel\Request\BaseRequest;

		$info = array(
			"host"  => "local.Chevron.com",
			"query" => "mobile=phones",
			"path"  => "/path/to/file.html",
		);

		$result = $request->parse_extended($info);

		$expected = array(
			"host"             => "local.Chevron.com",
			"top_level_domain" => "com",
			"domain"           => "Chevron",
			"sub_domain"       => "local",
			"query"            => "mobile=phones",
			"query_arr"        => array("mobile"=>"phones"),
			"path"             => "/path/to/file.html",
			"dirname"          => "/path/to",
			"basename"         => "file.html",
			"filename"         => "file",
			"extension"        => "html",
			'hash'             => '68527be74e41edaf65030fba85e9011d'
		);

		$this->assertEquals($expected, $result);

	}

	public function test_parse_extended_nulls(){
		$request = new \Chevron\Kernel\Request\BaseRequest;

		$info = array(
			"host"  => null,
			"query" => "mobile=phones",
			"path"  => "/path/to/file.html",
		);

		$result = $request->parse_extended($info);

		$expected = array(
			"host"             => "",
			"top_level_domain" => "",
			"domain"           => "",
			"sub_domain"       => "",
			"query"            => "mobile=phones",
			"query_arr"        => array("mobile"=>"phones"),
			"path"             => "/path/to/file.html",
			"dirname"          => "/path/to",
			"basename"         => "file.html",
			"filename"         => "file",
			"extension"        => "html",
			'hash'             => '68527be74e41edaf65030fba85e9011d'
		);

		$this->assertEquals($expected, $result);

	}

	public function test_parse_absolute_url(){
		$url = "http://local.testing.com/dir/file.html?qry=str&snow=white";

		$request = new \Chevron\Kernel\Request\BaseRequest;
		$result  = $request->parse($url);

		$expected = array(
			"getScheme"           => "http",
			"getHost"             => "local.testing.com",
			"getPort"             => "",
			"getPath"             => "/dir/file.html",
			"getQuery"            => "qry=str&snow=white",
			"getSubDomain"       => "local",
			"getDomain"           => "testing",
			"getTopLevelDomain" => "com",
			"getUser"             => "",
			"getPass"             => "",
			"getQueryArr"        => array(
				"qry"=>"str",
				"snow"=>"white"
			),
			"getDirname"          => "/dir",
			"getBasename"         => "file.html",
			"getExtension"        => "html",
			"getFilename"         => "file",
			"getAction"           => "GET",
		);

		foreach($expected as $method => $value){
			$this->assertEquals($request->$method(), $value);
		}

	}

	public function test_parse_absolute_url_empty_query(){
		$url = "http://local.testing.com/dir/file.html";

		$request = new \Chevron\Kernel\Request\BaseRequest;
		$result  = $request->parse($url);

		$expected = array(
			"getScheme"           => "http",
			"getHost"             => "local.testing.com",
			"getPort"             => "",
			"getPath"             => "/dir/file.html",
			"getQuery"            => "",
			"getSubDomain"       => "local",
			"getDomain"           => "testing",
			"getTopLevelDomain" => "com",
			"getUser"             => "",
			"getPass"             => "",
			"getQueryArr"        => array(),
			"getDirname"          => "/dir",
			"getBasename"         => "file.html",
			"getExtension"        => "html",
			"getFilename"         => "file",
			"getAction"           => "GET",
		);

		foreach($expected as $method => $value){
			$this->assertEquals($request->$method(), $value);
		}

	}

	public function test_parse_relative_url_empty_query(){
		$url = "/dir/file.html";

		$request = new \Chevron\Kernel\Request\BaseRequest;
		$result  = $request->parse($url);

		$expected = array(
			"getScheme"           => "",
			"getHost"             => "",
			"getPort"             => "",
			"getPath"             => "/dir/file.html",
			"getQuery"            => "",
			"getSubDomain"       => "",
			"getDomain"           => "",
			"getTopLevelDomain" => "",
			"getUser"             => "",
			"getPass"             => "",
			"getQueryArr"        => array(),
			"getDirname"          => "/dir",
			"getBasename"         => "file.html",
			"getExtension"        => "html",
			"getFilename"         => "file",
			"getAction"           => "GET",
		);

		foreach($expected as $method => $value){
			$this->assertEquals($request->$method(), $value);
		}

	}

	public function test_parse_relative_url(){
		$url = "/dir/file.html?q=s&t=f";

		$request = new \Chevron\Kernel\Request\BaseRequest;
		$result  = $request->parse($url);

		$expected = array(
			"getScheme"           => "",
			"getHost"             => "",
			"getPort"             => "",
			"getPath"             => "/dir/file.html",
			"getQuery"            => "q=s&t=f",
			"getSubDomain"       => "",
			"getDomain"           => "",
			"getTopLevelDomain" => "",
			"getUser"             => "",
			"getPass"             => "",
			"getQueryArr"        => array(
				"q" => "s",
				"t" => "f",
			),
			"getDirname"          => "/dir",
			"getBasename"         => "file.html",
			"getExtension"        => "html",
			"getFilename"         => "file",
			"getAction"           => "GET",
		);

		foreach($expected as $method => $value){
			$this->assertEquals($request->$method(), $value);
		}

	}

	public function get_seed_request_absolute(){
		$url = "http://local.testing.com/dir/file.html?qry=str&snow=white";

		$request = new \Chevron\Kernel\Request\BaseRequest;
		$result  = $request->parse($url);
		return $request;

	}

	public function get_seed_request_relative(){
		$url = "/dir/file.html?qry=str&snow=white";

		$request = new \Chevron\Kernel\Request\BaseRequest;
		$result  = $request->parse($url);
		return $request;

	}

	/**
	 * @depends test_parse_absolute_url
	 */
	public function test_build_absolute(){
		$request = $this->get_seed_request_absolute();

		$result = $request->build();
		$url = "http://local.testing.com/dir/file.html?qry=str&snow=white";

		$this->assertEquals($url, $result);

	}

	/**
	 * @depends test_parse_relative_url
	 */
	public function test_bulid_relative(){
		$request = $this->get_seed_request_relative();

		$result = $request->build();
		$url = "/dir/file.html?qry=str&snow=white";

		$this->assertEquals($url, $result);

	}

	/**
	 * @depends test_parse_relative_url
	 */
	public function test_alter_request(){
		$request = $this->get_seed_request_relative();

		$changes = array(
			"host" => "Chevron.com",
			"port" => "8080",
		);

		$result = $request->alter_request($changes);

		$expected = array(
			"getScheme"           => "",
			"getHost"             => "Chevron.com",
			"getPort"             => "8080",
			"getPath"             => "/dir/file.html",
			"getQuery"            => "qry=str&snow=white",
			"getSubDomain"       => "",
			"getDomain"           => "Chevron",
			"getTopLevelDomain" => "com",
			"getUser"             => "",
			"getPass"             => "",
			"getQueryArr"        => array(
				"qry" => "str",
				"snow" => "white",
			),
			"getDirname"          => "/dir",
			"getBasename"         => "file.html",
			"getExtension"        => "html",
			"getFilename"         => "file",
			"getAction"           => "GET",
		);

		foreach($expected as $method => $value){
			$this->assertEquals($request->$method(), $value);
		}
	}

	/**
	 * @depends test_parse_relative_url
	 */
	public function test_build_altered_request(){
		$request = $this->get_seed_request_relative();

		$changes = array(
			"host" => "Chevron.com",
			"port" => "8080",
		);

		$result = $request->alter_request($changes);
		$result = $request->build();

		$url = "http://Chevron.com:8080/dir/file.html?qry=str&snow=white";

		$this->assertEquals($url, $result);

	}

	/**
	 * @depends test_parse_relative_url
	 */
	public function test_build_altered_request_with_auth(){
		$request = $this->get_seed_request_relative();

		$changes = array(
			"host"   => "Chevron.com",
			"port"   => "8080",
			"user"   => "goose",
			"pass"   => "dog",
		);

		$result = $request->alter_request($changes);
		$result = $request->build();

		$url = "http://goose:dog@Chevron.com:8080/dir/file.html?qry=str&snow=white";

		$this->assertEquals($url, $result);

	}

	/**
	 * @depends test_build_altered_request
	 */
	public function test_alter_query_preserve(){
		$request = $this->get_seed_request_relative();

		$changes = array(
			"host"   => "Chevron.com",
			"port"   => "8080",
			"user"   => "goose",
			"pass"   => "dog",
			"spaces" => "goose is a dog",
		);

		$result = $request->alter_query($changes);

		$query       = "qry=str&snow=white&host=Chevron.com&port=8080&user=goose&pass=dog&spaces=goose+is+a+dog";
		$query_arr = array(
			"qry"    => "str",
			"snow"   => "white",
			"host"   => "Chevron.com",
			"port"   => "8080",
			"user"   => "goose",
			"pass"   => "dog",
			"spaces" => "goose is a dog",
		);

		$this->assertEquals($query, $request->getQuery());
		$this->assertEquals($query_arr, $request->getQueryArr());

	}

	/**
	 * @depends test_build_altered_request
	 */
	public function test_alter_query_no_preserve(){
		$request = $this->get_seed_request_relative();

		$changes = array(
			"host"   => "Chevron.com",
			"port"   => "8080",
			"user"   => "goose",
			"pass"   => "dog",
			"spaces" => "goose is a dog",
		);

		$result = $request->alter_query($changes, false);

		$query       = "host=Chevron.com&port=8080&user=goose&pass=dog&spaces=goose+is+a+dog";
		$query_arr = array(
			"host"   => "Chevron.com",
			"port"   => "8080",
			"user"   => "goose",
			"pass"   => "dog",
			"spaces" => "goose is a dog",
		);

		$this->assertEquals($query, $request->getQuery());
		$this->assertEquals($query_arr, $request->getQueryArr());

	}

	/**
	 * @depends test_alter_query_no_preserve
	 */
	public function test_rebuild_absolute(){
		$request = $this->get_seed_request_absolute();

		$changes = array(
			"host"   => "Chevron.com",
			"port"   => "8080",
			"user"   => "goose",
			"pass"   => "dog",
			"spaces" => "goose is a dog",
		);

		$result = $request->rebuild($changes, false);

		$url = "http://local.testing.com/dir/file.html?host=Chevron.com&port=8080&user=goose&pass=dog&spaces=goose+is+a+dog";

		$this->assertEquals($url, $result);
	}

	public function test_magic_get(){
		$request = $this->get_seed_request_absolute();

		$scheme  = $request->getScheme();
		$domain  = $request->getDomain();
		$host    = $request->getHost();
		$dirname = $request->getDirname();

		$this->assertEquals("http",              $scheme,  "Request::__get failed to get the scheme property");
		$this->assertEquals("testing",           $domain,  "Request::__get failed to get the domain property");
		$this->assertEquals("local.testing.com", $host,    "Request::__get failed to get the host property");
		$this->assertEquals("/dir",              $dirname, "Request::__get failed to get the dirname property");

	}

}

