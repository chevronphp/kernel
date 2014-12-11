<?php

use Chevron\Loggers;
use Psr\Log;

return function($di){

	$di->set("log.output.cli", function(){
		return new Loggers\CliLogger;
	});

	$di->set("log.output.file", function(){
		return new Log\NullLogger;
	});

	$di->set("log.error.dispatcher", function(){
		return new Log\NullLogger;
	});

	$di->set("log.error.router", function(){
		return new Log\NullLogger;
	});

	$di->set("log.error.db", function(){
		return new Log\NullLogger;
	});

};