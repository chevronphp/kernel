<?php

return function($di){

	$di->set("views.layout", function(){
		return new \Chevron\Widgets\Layout(DIR_LAYOUTS . "/index.php");
	});

	$di->set("views.dispatcher", function(){
		return new \Chevron\Widgets\Dispatcher(DIR_VIEWS);
	});

};