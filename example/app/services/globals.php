<?php

use \Chevron\Containers;

return function($di){

	$di->set("config", function(){
		return [];
	});

	$di->set("cli.argv", function(){
		return new \Chevron\Argv\Argv($_SERVER["argv"]);
	});

	$di->set("http.get", function(){
		return $_GET;
	});

	$di->set("http.post", function(){
		return $_POST;
	});

	$di->set("http.response", function(){
		return new Chevron\Kernel\Response\Headers;
	});

	$di->set("session.general", function(){
		if( session_status() != PHP_SESSION_ACTIVE ) {
			session_start();
		}
		if( !isset($_SESSION["chevron_sessions"]) ) {
			$_SESSION["chevron_sessions"] = array();
		}

		$ref = new Containers\Reference($_SESSION["chevron_sessions"]);
	});

};