<?php

require_once('config.php');
require_once('dibi.min.php');

// connect to database
try {
	$DATABASE = new DibiConnection(array(
		'driver' => 'mysql',
		'host' => 'localhost',
		'username' => MYSQL_USERNAME,
		'password' => MYSQL_PASSWORD,
		'database' => MYSQL_DBNAME,
	));
} catch (DibiException $e) {
	echo get_class($e), ': ', $e->getMessage(), "\n";
}
