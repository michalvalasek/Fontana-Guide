<?php

require_once('config.php');
//require_once('ProgramItem.php');

if ( isset($_POST['email']) ) {
	
	$email = $_POST['email'];
	
	if ( !empty($email) && preg_match(REGEX_VALID_EMAIL,$email) ) {
		$storage = file_get_contents(STORAGE_FILE_EMAILS);
		$items = unserialize($storage);

		if ( !is_array($items) ) {
			$items = array();
		}

		if ( !in_array($email,$items) ) {
			$items[] = $email;
			$res = file_put_contents(STORAGE_FILE_EMAILS,serialize($items));
			if ( $res==FALSE ) {
				$tpl_data['message'] = "Nastala chyba pri ukladaní adresy.";
				$tpl_data['button'] = '<a href="add_email.php" data-role="button" data-icon="arrow-l" data-transition="fade">Zadať znova</a>';
				include('templates/message.phtml');
				die;
			}
		}
		$tpl_data['message'] = "Vaša adresa bola uložená.";
		include('templates/message.phtml');
	}
	else {
		$tpl_data['message'] = "Chybná e-mailová adresa.";
		$tpl_data['button'] = '<a href="add_email.php" data-role="button" data-icon="arrow-l" data-transition="fade">Zadať znova</a>';
		include('templates/message.phtml');
	}
	
}
else {
	include('templates/add_email.phtml');
}