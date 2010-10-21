<?php

if ( !isset($_GET['token']) || $_GET['token']!=='ff161c5f724f8cd1c01b355da7e1a1ef' ) {
	die('Invalid token.');
}

require_once('config.php');
require_once('ProgramItem.php');
require_once('ZFmail.php');

$storage = file_get_contents(STORAGE_FILE);
$items = unserialize($storage);

$comming_items = array();

foreach($items as $i) {
    if ( date('Ymd',$i->timestamp)==date('Ymd',time()) ) {
		$comming_items[] = $i;
	}
}

if ( count($comming_items)>0 ) {
    
	$storage_emails = file_get_contents(STORAGE_FILE_EMAILS);
	$emails = unserialize($storage_emails);

	$from = 'Fontana Guide <fontana@michalvalasek.net>';
	$subject = 'Dnešné predstavenia '.date('d.m.Y',time());
	$message = "Dnes v kine Fontána uvádzajú nasledujúce predstavenia:\n\n";
	foreach($comming_items as $ci) {
		$message .= "Cas: ".date('H:i',$ci->timestamp)."\n";
    	$message .= $ci->title."\n";
    	$message .= $ci->type."\n";
    	$message .= $ci->description."\n";
    	$message .= $ci->info."\n\n";
	}
	
	$res = FALSE;
	if ( is_array($emails) && count($emails)>0 ) {
		foreach ( $emails as $email ) {
			if ( preg_match(REGEX_VALID_EMAIL,$email) ) {
				$to = $email;
				$mail = new ZFmail($to,$from,$subject,$message);
		    	$res = $mail->send();
			}
		}
	}
	else {
		$to = EMAIL_NOTIFICATION_TO;
		$mail = new ZFmail($to,$from,$subject,$message);
    	$res = $mail->send();
	}
	if ( $res == TRUE ) {
		echo "Fontana Guide: ".count($comming_items)." notification emails sent.";
	}
	else {
		echo "Fontana Guide: Notification emails NOT sent";
	}
}
else {
	echo "Fontana Guide: No comming items today.";
}