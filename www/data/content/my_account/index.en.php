<?php

	session_start();

	// Check user logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: /en/login/?referer=/en/my_account/');
		exit;
	}

	header('Location: /en/my_account/session/');

?>
