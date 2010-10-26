<?php

require_once('init.php');

if ( isset($_POST['email']) ) {
	
	$email = $_POST['email'];
	
	if ( !empty($email) && preg_match(REGEX_VALID_EMAIL,$email) ) {
		
		$emails = $DATABASE->query('SELECT * FROM [emails]')->fetchAssoc('email');
		if ( ! isset($emails[$email]) )
		{
			try {
				$DATABASE->query('INSERT INTO [emails]',array('email'=>$email));
			}
			catch (DibiException $e) {
				$tpl_data['message'] = "Nastala chyba pri ukladaní adresy. (".get_class($e).': '.$e->getMessage().")";
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