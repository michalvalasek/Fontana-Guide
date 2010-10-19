<?php

require_once('config.php');
require_once('ProgramItem.php');

$storage = file_get_contents(STORAGE_FILE);
$items = unserialize($storage);

$curr_date = '';

include('templates/front.phtml');