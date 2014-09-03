<?php

class Basic {

	protected $test = 5;

	function getTest(){
		return $this->test . "\n\n";
	}

	// function __construct(){
	// 	// $this->test = $int;
	// }

}

$class = new ReflectionClass("Basic");

if($class->isInstantiable()){
	try{
		$instance = $class->newInstanceArgs([3]);
	}catch(ReflectionException $e){
		print_r($e);
		exit(1);
	}
}


echo $instance->getTest();
exit(0);