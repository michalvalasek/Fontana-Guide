<?php

require_once('init.php');

if ( !isset($_GET['token']) || $_GET['token']!=CRON_TOKEN ) {
	die('Invalid token.');
}

if (!@$html=file_get_contents(REMOTE_SITE)) {
	output_msg("Remote site unaccessible!");
	return;
}

$dom = new domDocument;
@$dom->loadHTML('<?xml encoding="UTF-8">'.$html);
$dom->preserveWhiteSpace = FALSE;

$table = $dom->getElementsByTagName('table')->item(7);

for($i=1; $i<=$table->childNodes->length; $i++)
{
	if ( $i%2 ) continue;
	$tag = $table->childNodes->item($i-1);
	if ($tag->nodeName=="tr")
	{
		$item_data = array(
			'title' => $tag->childNodes->item(4)->getElementsByTagName('span')->item(0)->nodeValue,
			'description' => $tag->childNodes->item(4)->getElementsByTagName('div')->item(0)->nodeValue,
			'type' => $tag->childNodes->item(4)->getElementsByTagName('td')->item(0)->nodeValue,
			'info' => $tag->childNodes->item(4)->getElementsByTagName('b')->item(1)->nodeValue,
		);
		
		$DATABASE->query('INSERT INTO [events]',$item_data);
		$last_id = $DATABASE->insertId();
		
		$dates = explode('|',str_replace('hod','hod|',$tag->childNodes->item(2)->nodeValue));
		array_pop($dates);
		foreach($dates as $d) {
			$timestamp = dateToTimestamp($d);
			$date_data = array(
				'event_id' => $last_id,
				'date' => date('Ymd',$timestamp),
				'timestamp' => $timestamp,
			);
			$DATABASE->query('INSERT INTO [dates]',$date_data);
		}		
	}
}




// HELPER FUNCTIONS

function output_msg( $message )
{
	$output_tpl = <<<EOT
Fontana Guide - parser script
-----------------------------
%s
%s
EOT;
	echo nl2br(sprintf($output_tpl,date('D.m.y. H:i:s'),$message));
}


function dateToTimestamp( $date_raw )
{
	$d = intval($date_raw{0}.$date_raw{1});
	$m = intval($date_raw{3}.$date_raw{4});
	$y = intval($date_raw{6}.$date_raw{7}.$date_raw{8}.$date_raw{9});
	$h = intval($date_raw{13}.$date_raw{14});// + 7; //nutny fix, ale neviem preco
	$i = intval($date_raw{16}.$date_raw{17});
	return mktime($h,$i,0,$m,$d,$y);
}