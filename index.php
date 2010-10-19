<?php

require_once('config.php');
require_once('ProgramItem.php');

$storage = file_get_contents(STORAGE_FILE);
$items = unserialize($storage);

$output = <<<EOT
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<title>Fontana Guide</title>
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0a1/jquery.mobile-1.0a1.min.css" />
	<script type="text/javascript" charset="utf-8" src="http://code.jquery.com/jquery-1.4.3.min.js"></script>
	<script type="text/javascript" charset="utf-8" src="http://code.jquery.com/mobile/1.0a1/jquery.mobile-1.0a1.min.js"></script>
</head>
<body>
<div data-role="page" id="bgf-frontpage">
	<div data-role="header">
		<h1>Fontana Guide</h1>
	</div>
	<div data-role="content">
		<ul data-role="listview">
EOT;

$curr_date = '';
foreach($items as $i) {
	if ( $curr_date=='' || date('Ymd',$i->timestamp)>$curr_date ) {
		$curr_date = date('Ymd',$i->timestamp);
		$output .= '<li data-role="list-divider">'.date('d.m.Y',$i->timestamp).'</li>'."\n";
	}
	$output .= '<li><a href="#bgf-itempage-'.$i->hash.'"><h5>'.date('H:i',$i->timestamp).'</h5><p><strong>'.$i->title.'</strong></p><p>'.$i->type.'</p></a></li>'."\n";
}

$output .= '</ul></div><div data-role="footer"><h4>App by<br />BinaryGoo</h4></div></div>';

foreach($items as $i) {
	$output .= '<div data-role="page" id="bgf-itempage-'.$i->hash.'">
	<div data-role="header"><h1>Fontana Guide</h1></div>
	<div data-role="content">';
	$output .= '<h2>'.$i->title.'</h2>';
	$output .= '<p><small>'.$i->type.'</small></p>';
	$output .= '<p>'.$i->description.'</p>';
	$output .= '<p><em>'.$i->info.'</em></p>';
	$output .= '<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b">';
	$output .= '<li data-role="list-divider">Premietania</li>';
	foreach($i->dates as $d) {
		$output .= '<li>'.$d.'</li>';
	}
	$output .= '</ul>';
	$output .= '</div><div data-role="footer"><h4>App by<br />BinaryGoo</h4></div></div>';
}

$output .= '</body></html>';

echo $output;
