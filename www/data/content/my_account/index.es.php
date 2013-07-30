<?php

	session_start();

	// Check user logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: /es/login/?referer=/es/my_account/');
		exit;
	}

	header('Location: /es/my_account/session/');

?>
