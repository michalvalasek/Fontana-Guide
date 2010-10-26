<?php

require_once('dibi.min.php');

try {
	$database = new DibiConnection(array(
		'driver'   => 'sqlite3',
		'database' => 'db/fontana.sdb',
	));
} catch (DibiException $e) {
	echo get_class($e), ': ', $e->getMessage(), "\n";
}

/***/

$data = array(
	'title' => 'event 1',
	'description' => 'description 1',
	'info' => 'info 1',
	'type' => 'type 1'
);
$database->query('INSERT INTO [events]',$data);

echo $database->getInsertId();

/***/

$result = $database->query('SELECT * FROM [events]');

foreach ($result as $n => $row) {
    print_r($row);
}

unset($result);