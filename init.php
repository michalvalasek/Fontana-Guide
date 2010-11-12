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

$WEEKDAYS = array(
	1 => 'Pondelok',
	2 => 'Utorok',
	3 => 'Streda',
	4 => 'Štvrtok',
	5 => 'Piatok',
	6 => 'Sobota',
	7 => 'Nedeľa',
);
