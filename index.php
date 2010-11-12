<?php

require_once('init.php');

$dates = $DATABASE->query('SELECT * FROM [dates] ORDER BY [timestamp]')->fetchAll();
$events = $DATABASE->query('SELECT * FROM [events]')->fetchAssoc('id');

$curr_date = '';

include('templates/front.phtml');