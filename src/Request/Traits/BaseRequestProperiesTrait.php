<?php

namespace Chevron\Kernel\Request\Traits;

trait BaseRequestProperiesTrait {

	/**
	 * the scheme
	 */
	protected $scheme;

	/**
	 * the host
	 */
	protected $host;

	/**
	 * the port
	 */
	protected $port;

	/**
	 * the path
	 */
	protected $path;

	/**
	 * the query
	 */
	protected $query;

	/**
	 * the subDomain
	 */
	protected $sub_domain;

	/**
	 * the domain
	 */
	protected $domain;

	/**
	 * the topLevelDomain
	 */
	protected $top_level_domain;

	/**
	 * the user
	 */
	protected $user;

	/**
	 * the pass
	 */
	protected $pass;

	/**
	 * the queryArr
	 */
	protected $query_arr = [];

	/**
	 * the dirname
	 */
	protected $dirname;

	/**
	 * the basename
	 */
	protected $basename;

	/**
	 * the extension
	 */
	protected $extension;

	/**
	 * the filename
	 */
	protected $filename;

	/**
	 * the action
	 */
	protected $action;

	/**
	 * the hash
	 */
	protected $hash;

	/**
	 * the statusCode
	 */
	protected $status_code = 200;

	/**
	 * the contentType
	 */
	protected $content_type;

	/**
	 * get the scheme
	 * @return string
	 */
	function getScheme(){
		return $this->scheme;
	}

	/**
	 * set the scheme
	 * @param string
	 */
	function setScheme($scheme){
		$this->scheme = $scheme;
	}

	/**
	 * get the host
	 * @return string
	 */
	function getHost(){
		return $this->host;
	}

	/**
	 * set the host
	 * @param string
	 */
	function setHost($host){
		$this->host = $host;
	}

	/**
	 * get the port
	 * @return string
	 */
	function getPort(){
		return $this->port;
	}

	/**
	 * set the port
	 * @param string
	 */
	function setPort($port){
		$this->port = $port;
	}

	/**
	 * get the path
	 * @return string
	 */
	function getPath(){
		return $this->path;
	}

	/**
	 * set the path
	 * @param string
	 */
	function setPath($path){
		$this->path = $path;
	}

	/**
	 * get the query
	 * @return string
	 */
	function getQuery(){
		return $this->query;
	}

	/**
	 * set the query
	 * @param string
	 */
	function setQuery($query){
		$this->query = $query;
	}

	/**
	 * get the subDomain
	 * @return string
	 */
	function getSubDomain(){
		return $this->sub_domain;
	}

	/**
	 * set the subDomain
	 * @param string
	 */
	function setSubDomain($subdomain){
		$this->sub_domain = $subdomain;
	}

	/**
	 * get the domain
	 * @return string
	 */
	function getDomain(){
		return $this->domain;
	}

	/**
	 * set the domain
	 * @param string
	 */
	function setDomain($domain){
		$this->domain = $domain;
	}

	/**
	 * get the topLevelDomain
	 * @return string
	 */
	function getTopLevelDomain(){
		return $this->top_level_domain;
	}

	/**
	 * set the topLevelDomain
	 * @param string
	 */
	function setTopLevelDomain($topleveldomain){
		$this->top_level_domain = $topleveldomain;
	}

	/**
	 * get the user
	 * @return string
	 */
	function getUser(){
		return $this->user;
	}

	/**
	 * set the user
	 * @param string
	 */
	function setUser($user){
		$this->user = $user;
	}

	/**
	 * get the pass
	 * @return string
	 */
	function getPass(){
		return $this->pass;
	}

	/**
	 * set the pass
	 * @param string
	 */
	function setPass($pass){
		$this->pass = $pass;
	}

	/**
	 * get the queryArr
	 * @return array
	 */
	function getQueryArr(){
		return $this->query_arr;
	}

	/**
	 * set the queryArr
	 * @param array
	 */
	function setQueryArr(array $queryarr){
		$this->query_arr = $queryarr;
	}
	/**
	 * get the dirname
	 * @return string
	 */
	function getDirname(){
		return $this->dirname;
	}

	/**
	 * set the dirname
	 * @param string
	 */
	function setDirname($dirname){
		$this->dirname = $dirname;
	}

	/**
	 * get the basename
	 * @return string
	 */
	function getBasename(){
		return $this->basename;
	}

	/**
	 * set the basename
	 * @param string
	 */
	function setBasename($basename){
		$this->basename = $basename;
	}

	/**
	 * get the extension
	 * @return string
	 */
	function getExtension(){
		return $this->extension;
	}

	/**
	 * set the extension
	 * @param string
	 */
	function setExtension($extension){
		$this->extension = $extension;
	}

	/**
	 * get the filename
	 * @return string
	 */
	function getFilename(){
		return $this->filename;
	}

	/**
	 * set the filename
	 * @param string
	 */
	function setFilename($filename){
		$this->filename = $filename;
	}

	/**
	 * get the action
	 * @return string
	 */
	function getAction(){
		return $this->action;
	}

	/**
	 * set the action
	 * @param string
	 */
	function setAction($action){
		$this->action = $action;
	}

	/**
	 * get the hash
	 * @return string
	 */
	function getHash(){
		return $this->hash;
	}

	/**
	 * set the hash
	 * @param string
	 */
	function setHash($hash){
		$this->hash = $hash;
	}

	/**
	 * get the statusCode
	 * @return int
	 */
	function getStatusCode(){
		return $this->status_code;
	}

	/**
	 * set the statusCode
	 * @param string
	 */
	function setStatusCode($statuscode){
		$this->status_code = (int)$statuscode;
	}

	/**
	 * get the contentType
	 * @return string
	 */
	function getContentType(){
		return $this->content_type;
	}

	/**
	 * set the contentType
	 * @param string
	 */
	function setContentType($contenttype){
		$this->content_type = $contenttype;
	}

}