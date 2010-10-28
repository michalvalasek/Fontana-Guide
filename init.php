<?php

require_once('config.php');
require_once('dibi.min.php');

// connect to database
try {
	$DATABASE = new DibiConnection(array(
		//'driver'   => 'sqlite3',
		//'database' => 'db/fontana.sdb',
		'driver' => 'mysql',
		'host' => 'localhost',
		'username' => '',
		'password' => '',
		'database' => 'fontana',
	));
} catch (DibiException $e) {
	echo get_class($e), ': ', $e->getMessage(), "\n";
}
