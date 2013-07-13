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

	// Form data overrides any other data

	// Try to get data from the users database
	$query = "select * from users where id='".$sd['user']."'";
	$query_result = mysqli_query($db, $query);

	if (mysqli_num_rows($query_result)) {

		// $num_results should be 1 in this case

		$row = mysqli_fetch_assoc($query_result);

		if ($sd['user'] == $row['id'] &&
			hash('sha512', $db_salt.$sd['pass']) == $row['password']) {

			$_SESSION['user_id'] = $row['number'];

			// Check-in
			date_default_timezone_set('UTC');
			$query = "insert into session_log values ('".$_SESSION['user_id']."','".date("Y-m-d H:i:s")."');";
			$query_result = mysqli_query($db, $query);

			// Get user's permissions
			$query = "select * from permissions where user='".$_SESSION['user_id']."'";
			$query_result = mysqli_query($db, $query);

			if (mysqli_num_rows($query_result)) {

				$row = mysqli_fetch_assoc($query_result);

				$_SESSION['admin_permissions'] = $row['admin'];
				$_SESSION['company_permissions'] = $row['company'];
				$_SESSION['student_permissions'] = $row['student'];
				$_SESSION['invitations_permissions'] = $row['invitations'];
				$_SESSION['statistics_permissions'] = $row['statistics'];
				$_SESSION['banners_permissions'] = $row['banners'];
				$_SESSION['wiki_permissions'] = $row['wiki'];

			} else {

				$_SESSION['user_do_not_have_permissions'] = 1;

			}

		} else {
			echo $err_wrong_username_or_password;
			$processing_error = 1;
		}

	} else {
		echo $err_wrong_username_or_password;
		$processing_error = 1;
	}

?>
