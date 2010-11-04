<?php

require_once('init.php');

if ( !isset($_GET['token']) || $_GET['token']!=CRON_TOKEN ) {
	die('Invalid token.');
}

require_once('ZFmail.php');

$today = date('Ymd');
$comming_items = $DATABASE->query('SELECT events.*, dates.timestamp FROM dates LEFT JOIN events ON events.id=dates.event_id WHERE dates.date=%s',$today)->fetchAll();

if ( count($comming_items)>0 ) {
    
	$emails = $DATABASE->query('SELECT * FROM [emails]')->fetchAll();
	
	$from = 'Fontana Guide <fontana@binarygoo.com>';
	$subject = 'Dnešné predstavenia '.date('d.m.Y',time());
	$message = "Dnes v kine Fontána uvádzajú nasledujúce predstavenia:\n\n";
	foreach($comming_items as $ci) {
		$message .= "Cas: ".date('H:i',$ci->timestamp)."\n";
    	$message .= $ci->title."\n";
    	$message .= $ci->type."\n";
    	$message .= $ci->description."\n";
    	$message .= $ci->info."\n\n";
	}
	$message .= "\nFontana Guide\n";
	$message .= "http://fontana.binarygoo.com";
	
	$res = FALSE;
	if ( count($emails)>0 ) {
		foreach ( $emails as $email ) {
			if ( preg_match(REGEX_VALID_EMAIL,$email->email) ) {
				$to = $email->email;
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
		$report = "Fontana Guide: ".count($emails)." notification emails sent.";
	}
	else {
		$report = "Fontana Guide: Notification emails NOT sent";
	}
}
else {
	$report = "Fontana Guide: No comming items today.";
}

// send report
$mail = new ZFmail($to,'fontana@binarygoo.com','Notifier report '.date('d.m.Y'),$report);
$mail->send();