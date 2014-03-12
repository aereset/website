<?php

	/*
	 * Sanitize aditional data (ex: $_GET variables or any other data
	 * that you might be using for MySQL queries and that has not
	 * been sanitized yet)
	 */

	/*
	 * Form data has already been sanitized, so it should not be
	 * dangerous to use it for MySQL queries. Anyway, you should check
	 * that the data is in this variables is the one you are looking
	 * for: variable type, range...
	 *
	 * If you find an input error, you should set the variable
	 * $input_error['name'] to 1, being 'name' the name of the
	 * corresponding form input.
	 */

	/*
	 * If you find any other processing error, remember to set the
	 * variable $processing_error to '1'.
	 */

	// Create invitation
	date_default_timezone_set('UTC');
	$expiration_date = date("Y-m-d H:i:s", strtotime("+2 days"));
	$invitation_key = hash('sha512', $sd['email'].$expiration_date.$db_salt.rand());

	$i = 0;
	$permissions = '';
	// Check the user has the permissions that will be shared
	foreach (array('admin', 'invitations', 'banners', 'news', 'wiki') as $p) {
		if (isset($sd[$p]) && $sd[$p] == 1 && isset($_SESSION[$p.'_permissions']) && $_SESSION[$p.'_permissions'] == 1) {
			if ($i > 0) $permissions .= ',';
			$permissions .= $p;
			$i++;
		}
	}

	$query = "insert into invitations (user,invitation_key,expiration,permissions) values ('".$_SESSION['user_id']."','".$invitation_key."','".$expiration_date."','".$permissions."')";
	$result = mysqli_query($db, $query);

	if ($result) {

		echo '<p class="warning">Share <a href="/invitation/?key='.$invitation_key.'">the invitation link that has been created</a> with your friend for him/her to accept it. Remember the invitation can only be used once and will expire in <strong>48 hours</strong>.</p>';

	} else {

		echo $err_writing_to_db;
		$processing_error = 1;

	}

?>
