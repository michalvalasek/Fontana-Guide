<?php

require_once('init.php');

$dates = $DATABASE->query('SELECT * FROM [dates] ORDER BY [timestamp]')->fetchAll();
$events = $DATABASE->query('SELECT * FROM [events]')->fetchAssoc('id');

$weekdays = array(
	1 => 'Pondelok',
	2 => 'Utorok',
	3 => 'Streda',
	4 => 'Štvrtok',
	5 => 'Piatok',
	6 => 'Sobota',
	7 => 'Nedeľa',
);

$curr_date = '';

include('templates/front.phtml');