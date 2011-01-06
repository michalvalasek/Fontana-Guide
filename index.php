<?php

require_once('init.php');

$dates = $DATABASE->query('SELECT * FROM [dates] WHERE [timestamp]>%i ORDER BY [timestamp]',time())->fetchAll();
$events = $DATABASE->query('SELECT * FROM [events]')->fetchAssoc('id');

$curr_date = '';

include('templates/front.phtml');