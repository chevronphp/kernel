<?php

namespace Chevron\Kernel\Request;

class BaseRequest {

	use Traits\BaseRequestProperiesTrait;

	function __construct( $url = "", array $query = array() ){
		if(empty($url)) return;

		if($query){
			if( false != ($pos = strpos($url, "?"))){
				$url = substr($url, 0, $pos);
			}
			$query = http_build_query($query, "no_", "&");
			$url   = "{$url}?{$query}";
		}
		$this->parse($url);
	}

	/**
	 * parse a url into its component parts
	 * @param string $url The URL to parse
	 * @param string $action The action of the request
	 * @return \Chevron\Requests\BaseRequest
	 * @throws \Exception
	 */
	function parse( $url = "", $action = "GET" ){
		if(!$url){
			throw new \Exception("A valid url must be supplied to parse");
		}

		if(($info = parse_url( $url )) === false){
			throw new \Exception("Cannot parse seriously malformed URL");
		}

		$info = $this->parse_extended($info);

		$this->setAction($action);

		foreach($info as $name => $value){
			if(property_exists($this, $name)){
				$this->$name = $value;
			}
		}
	}

	/**
	 * parse the query, host, and path params into a more extended format
	 * @param array $info An array to parse
	 * @return array
	 */
	function parse_extended(array $info){
		if(array_key_exists("query", $info)){
			$info["query_arr"] = array();
			parse_str($info["query"], $info["query_arr"]);
		}

		if(array_key_exists("host", $info)){
			$domain = explode(".", $info['host']);
			$info["top_level_domain"] = array_pop($domain) ?: "";
			$info["domain"]           = array_pop($domain) ?: "";
			$info["sub_domain"]       = implode(".", $domain) ?: "";
		}

		if(array_key_exists("path", $info)){
			$info["hash"] = hash("md5", $info["path"]);
			$parts = pathinfo($info["path"]);
			foreach($parts as $name => $value){
				$info[$name] = $value;
			}
		}
		return $info;
	}

	/**
	 * build the current request object
	 * @return string
	 */
	function build(){
		$url = static::build_url($this);
		return $url;
	}

	/**
	 * change parts of the request object
	 * @param type array $info
	 */
	function alter_request(array $info){
		foreach($info as $part => $value){
			switch(true){
				case $part == "host" :
					$temp = $this->parse_extended(array($part => $value));
					$this->setHost($value);
					$this->setTopLevelDomain($temp["top_level_domain"]);
					$this->setDomain($temp["domain"]);
					$this->setSubDomain($temp["sub_domain"]);
				break;
				case $part == "query"     : break;
				case $part == "query_arr" : break;
				case $part == "path"      :
					$temp = $this->parse_extended(array($part => $value));
					$this->setPath($value);
					$this->setDirname($temp["dirname"]);
					$this->setBasename($temp["basename"]);
					$this->setExtension($temp["extension"]);
					$this->setFilename($temp["filename"]);
				break;
				default :
					$setter = "set{$part}";
					if(method_exists($this, $setter)){
						$this->$setter($value);
					}
				break;
			}
		}
	}

	/**
	 * change parts of the current request object
	 * @param array $params The params to add
	 * @param bool $preserve Whether to preserve the requests current query
	 */
	function alter_query(array $params, $preserve = true){
		if($preserve){
			$params = array_merge($this->getQueryArr(), $params);
		}
		$this->setQuery(http_build_query($params, "no_", "&"));
		$this->setQueryArr($params);
	}

	/**
	 * shortcut to changing and then building the current request object
	 * @param array $params The new query
	 * @param bool $preserve Whether to preserve the current query
	 * @return string
	 */
	function rebuild(array $params = array(), $preserve = true) {
		$this->alter_query($params, $preserve);

		return $this->build();
	}

	/**
	 * method to take a Request object and reconstitute it to a full URL. if the
	 * "host" param is empty, the URL will be relative
	 * @param \Chevron\Requests\BaseRequest $request The object to reconstitute
	 * @return string
	 */
	static function build_url( BaseRequest $request){

		$absolute = "";
		if($request->getHost()){

			$scheme = "http";
			if($request->getScheme()){
				$scheme = $request->getScheme();
			}

			$auth_prefix = "";
			if($request->getUser()){
				$auth_prefix = sprintf("%s:%s@", $request->getUser(), $request->getPass());
			}

			$port = "";
			if($request->getPort()){
				switch(true){
					case $request->getPort() == 80  : break;
					case $request->getPort() == 443 :
						$scheme = "https";
					break;
					default :
						$port = ":" . $request->getPort();
					break;
				}
			}

			$host = $request->getHost();
			$absolute = sprintf("%s://%s%s%s", $scheme, $auth_prefix, $host, $port);
		}

		$path = "";
		if($request->getPath()){
			$path = ltrim($request->getPath(), "/");
		}

		$query = "";
		if($request->getQueryArr()){
			$query = http_build_query($request->getQueryArr(), "no_", "&");
			$query = "?{$query}";
		}

		$url = sprintf("%s/%s%s", $absolute, $path, $query);
		return $url;

	}

}
