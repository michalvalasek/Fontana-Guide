<?php

if (!isset($_GET['id'])) {
	die('Error: No ID provided.');
}

$id = $_GET['id'];
if ( !preg_match('/^[0-9a-z]{32}$/',$id) ) {
	die('Error: Incorrect ID provided.');
}

require_once('config.php');
require_once('ProgramItem.php');

$storage = file_get_contents(STORAGE_FILE_UNIQUES);
$items = unserialize($storage);

if ( !isset($items[$id]) ) {
	die('Error: ID doesn\'t exist.');
}

$item = $items[$id];

include('templates/detail.phtml');