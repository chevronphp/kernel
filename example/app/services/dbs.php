<?php

use Chevron\DB;

return function($di){

	$factory = function($drv, $host, $port, $db, $chars, $u, $p){
		$dsn = "{$drv}:host={$host};port={$port};dbname={$db};charset={$chars}";
		return new \PDO($dsn, $u, $p);
	};

	$di->set("db", function()use($di, $factory){
		$conf = $di->get("config");
		$pdo  = $conf["pdo"];

		if($pdo["driver"] != "mysql"){
			return new DB\NullWrapper;
		}

		$conn = $factory(
			$pdo["driver"],
			$pdo["hostname"],
			$pdo["hostport"],
			$pdo["database"],
			$pdo["charset"],
			$pdo["username"],
			$pdo["password"]
		);

		$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		$conn->exec("SET time_zone = '-0:00'");
		$conn->exec(sprintf("SET timestamp = %d", time()));

		$inst = new DB\PDOWrapper;
		$inst->setConnection($conn);
		$inst->setDriver(new DB\Drivers\MySQLDriver);

		if($logger = $di->get("log.error.db")){
			$inst->setLogger($logger);
		}

		return $inst;

	});

};