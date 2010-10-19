<?php

require_once('config.php');
require_once('ProgramItem.php');

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

if (!@$html=file_get_contents(REMOTE_SITE)) {
	output_msg("Remote site unaccessible!");
	return;
}

$dom = new domDocument;
@$dom->loadHTML('<?xml encoding="UTF-8">'.$html);
$dom->preserveWhiteSpace = FALSE;

$table = $dom->getElementsByTagName('table')->item(7);

$items = array();

for($i=1; $i<=$table->childNodes->length; $i++) {
	if ( $i%2 ) continue;
	$tag = $table->childNodes->item($i-1);
	if ($tag->nodeName=="tr") {
		/*
		$item = new ProgramItem;
		$item->title = $tag->childNodes->item(4)->getElementsByTagName('span')->item(0)->nodeValue;
		$item->description = $tag->childNodes->item(4)->getElementsByTagName('div')->item(0)->nodeValue;
		$item->type = $tag->childNodes->item(4)->getElementsByTagName('td')->item(0)->nodeValue;
		$item->info = $tag->childNodes->item(4)->getElementsByTagName('b')->item(1)->nodeValue;
		$item->setDates($tag->childNodes->item(2)->nodeValue);
		$items[] = $item;
		*/
		
		$dates = explode('|',str_replace('hod','hod|',$tag->childNodes->item(2)->nodeValue));
		array_pop($dates);
		$item_data = array(
			'title' => $tag->childNodes->item(4)->getElementsByTagName('span')->item(0)->nodeValue,
			'description' => $tag->childNodes->item(4)->getElementsByTagName('div')->item(0)->nodeValue,
			'type' => $tag->childNodes->item(4)->getElementsByTagName('td')->item(0)->nodeValue,
			'info' => $tag->childNodes->item(4)->getElementsByTagName('b')->item(1)->nodeValue,
			'dates' => $dates,
		);
		foreach($dates as $d) {
			$item = new ProgramItem($item_data);
			$item->setTimestamp($d);
			$items[] = $item;
		}
	}
}

if ( file_put_contents(STORAGE_FILE,serialize($items)) ) {
	output_msg("DATA STORED SUCCESSFULLY");
}
else {
	output_msg("ERROR STORING DATA");
}

//echo "<pre>DATA STORED.<br /><br />";
var_dump($items);
