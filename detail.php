<?php

if (!isset($_GET['id'])) {
	die('Error: No ID provided.');
}

$event_id = $_GET['id'];
//if ( !preg_match('/^[0-9a-z]{32}$/',$id) ) {
if ( !preg_match('/^\d+$/',$event_id) ) {
	die('Error: Incorrect ID provided.');
}

require_once('init.php');

$event = $DATABASE->query('SELECT * FROM [events] WHERE [id]=%d',$event_id)->fetch();
if ( count($event)==0 ) {
	die('Error: ID doesn\'t exist.');
}

$dates = $DATABASE->query('SELECT * FROM [dates] WHERE [event_id]=%d',$event_id,'ORDER BY [timestamp]')->fetchAll();

include('templates/detail.phtml');